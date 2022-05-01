<template>
  <div
    v-if="roomInfo && roomInfo.id && roomInfo.car_name"
    v-show="isShow"
    class="flex-grow bg-slate-200 mr-0 md:mr-24"
    :class="{ 'chat-detail-mobile': isMobileScreen && isShow }"
  >
    <div v-if="isMobileScreen" class="items-center border-b p-4 bg-white w-full relative">
      <button class="absolute" @click="hide">
        <i class="fas fa-chevron-left"></i>
      </button>
      <div class="text-center pl-5">{{ roomInfo.company_name }}</div>
    </div>
    <div class="flex justify-between items-center border-b py-2 px-4 bg-white w-full">
      <div class="flex items-center">
        <div class="avatar">
          <div class="rounded-btn w-14 h-14 border">
            <img v-lozad="roomInfo.thumbnail" />
          </div>
        </div>
        <div class="ml-2 flex-grow">
          <a class="text-sm font-bold" :href="linkDetail" target="_blank">
            {{ roomInfo.car_name }}
          </a>
        </div>
      </div>
      <a :href="linkDetail" class="btn btn-xs btn-outline-primary border rounded-sm px-6">
        {{ roomStatus }}
      </a>
    </div>
    <div ref="list" class="flex flex-col overflow-y-auto relative pt-4 w-full" :style="height" @scroll="debounceScroll">
      <template v-for="(messages, date) in items">
        <p class="text-center text-xs">{{ date | moment('M月D日 (ddd)') }}</p>
        <template v-for="(message, i) in messages">
          <div class="flex mb-3" :class="{ 'justify-start': !message.self, 'justify-end': message.self }">
            <div v-if="!message.self" class="avatar mr-3">
              <div class="rounded-full w-10 h-10">
                <img v-lozad="roomInfo.thumbnail" />
              </div>
            </div>
            <div
              class="rounded p-3 max-w-[70%] md:max-w-md relative"
              :class="{ 'mr-2': message.self, 'bg-blue-500 text-white ': message.self, 'bg-white': !message.self }"
            >
              <div v-if="message.isImage"><img v-lozad="message.content" /></div>
              <div v-else class="whitespace-pre-wrap">{{ message.content }}</div>
              <span
                class="absolute text-xs text-gray-400 bottom-0"
                :class="{ '-right-10': !message.self, '-left-10': message.self }"
              >
                {{ message.created_at | moment('hh:mm') }}
              </span>
            </div>
          </div>
        </template>
      </template>
      <div v-show="isCallingApi" class="text-center mb-4">
        <svg
          class="animate-spin h-5 w-5 text-blue m-auto"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
          ></path>
        </svg>
      </div>
    </div>
    <div class="bg-white flex overflow-x-scroll">
      <div v-for="(image, key) in images" :key="key" class="relative flex-none p-2 lg:p-3">
        <span
          class="flex absolute right-0 justify-center items-center bg-slate-200 rounded-full h-5 w-5 cursor-pointer text-sm font-bold"
          @click="deleteImage(key)"
          >×</span
        >
        <img :src="makeImageUrl(image)" class="inline-block w-auto h-32 rounded-lg" />
      </div>
    </div>
    <div class="flex items-center border-t bg-white w-full h-12">
      <button class="btn btn-link no-underline" @click.prevent="onClickChooseFile">
        <img class="text-xl h-6 object-cover" src="/images/icon/icon-photo.png" />
      </button>
      <input ref="inputFile" multiple type="file" class="hidden" accept="image/*" @change="onChangeFile" />
      <div class="form-control w-full">
        <div class="flex items-center">
          <textarea
            v-model.trim="content"
            maxlength="1000"
            class="h-8 w-full input input-primary bg-gray-200 border border-gray-200 resize-none"
            @keyup.shift.enter="sendMessage"
          />
          <button class="btn btn-link no-underline" @click.prevent="sendMessage">
            <img class="text-xl h-6 object-cover" src="/images/icon/icon-send.png" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import listMixin from '../../mixins/list'
import debounce from 'lodash.debounce'

export default {
  name: 'ChatDetail',
  mixins: [listMixin],
  props: {
    roomInfo: {
      type: [Object],
      required: false,
      default: null,
    },
  },
  data() {
    return {
      paginationApi: () => this.getList(this.currentPage + 1),
      content: '',
      previousScrollHeight: 0,
      debounceScroll: () => {},
      debounceResize: () => {},
      isMobileScreen: false,
      isShow: true,
      oldIsShow: true,
      height: 'height: calc(100% - 137px);',
      images: [],
    }
  },
  computed: {
    linkDetail() {
      return '/car/detail/' + this.roomInfo.car_id
    },
    items() {
      const messages =
        this.listItems?.reduce((messages, item) => {
          const createdAt = this.$moment(item.created_at).format('YYYY-MM-DD')
          if (item.buyer_id == this.$userId || item.seller_id == this.$userId) {
            item.self = true
          } else {
            item.self = false
          }
          if (parseInt(item.type) === this.$config.CHAT.MESSAGE_TYPE_IMAGE) {
            item.isImage = true
          } else {
            item.isImage = false
          }
          messages[createdAt] = messages[createdAt] || []
          messages[createdAt].push(item)
          return messages
        }, {}) ?? {}

      // sort message by date
      const messagesSorted = Object.keys(messages)
        .sort()
        .reduce((obj, key) => {
          // sort message by id
          messages[key].sort((a, b) => {
            const $a = this.$moment(a.created_at)
            const $b = this.$moment(b.created_at)
            if ($a > $b) {
              return 1
            }
            if ($a < $b) {
              return -1
            }
            return a.id - b.id
          })
          obj[key] = messages[key]
          return obj
        }, {})

      return messagesSorted
    },
    lastMessageId() {
      const lastId = Math.max.apply(
        Math,
        this.listItems
          .filter(function (o) {
            return o.isCloud
          })
          .map(function (o) {
            return o.id
          })
      )
      return isFinite(lastId) ? lastId : 0
    },
    roomStatus() {
      // todo: logic room status
      return '車両詳細'
    },
  },
  watch: {
    'roomInfo.id'(val) {
      this.getFirstPage()
    },
    isMobileScreen(val) {
      if (val) {
        this.isShow = !!this.oldIsShow
        this.height = 'height: calc(100% - 178px);'
      } else {
        this.oldIsShow = this.isShow
        this.isShow = true
        this.height = 'height: calc(100% - 137px);'
      }
    },
    images() {
      if (this.isMobileScreen && this.images.length === 0) {
        this.height = 'height: calc(100% - 178px);'
      } else if (this.isMobileScreen && this.images.length > 0) {
        this.height = 'height: calc(100% - 354px);'
      } else if (!this.isMobileScreen && this.images.length === 0) {
        this.height = 'height: calc(100% - 137px);'
      } else {
        this.height = 'height: calc(100% - 325px);'
      }
    },
  },
  beforeDestroy() {
    window.removeEventListener('rezise')
  },
  async created() {
    this.debounceScroll = debounce(this.onScroll, 300, { leading: true })
    this.debounceResize = debounce(this.onWindowResize, 200, { leading: true })
    window.addEventListener('resize', this.debounceResize)
    this.onWindowResize()
    await this.getFirstPage()

    this.clearTimeout()
    this.setUpTimeout()
  },
  methods: {
    setUpTimeout() {
      this.timeout = setTimeout(this.timeOutHandler, 10000)
    },
    clearTimeout() {
      clearTimeout(this.timeout)
      this.timeout = undefined
    },
    async timeOutHandler() {
      if (!this.roomInfo?.id) {
        return
      }

      const apiResponse = await this.$api.getChatMessage(this.roomInfo.id, { last_id: this.lastMessageId })
      const listItems = apiResponse?.data ?? []
      if (listItems.length) {
        listItems.forEach(item => {
          this.addMessage(item)
        })
        this.scrollToBottom()
      }

      this.clearTimeout()
      this.setUpTimeout()
    },
    async paging() {
      if (this.isCanNext()) {
        this.isCallingApi = true
        const apiResponse = await this.paginationApi()

        if (apiResponse) {
          this.saveScrollPosition()
          const listItems = apiResponse?.data?.data ?? []
          listItems.forEach(item => {
            this.addMessage(item)
          })

          const carInfo = apiResponse?.data?.car
          if (carInfo && !this.roomInfo.car_name) {
            /* eslint-disable */
            this.roomInfo.thumbnail = carInfo.thumb?.url || ''
            this.roomInfo.car_id = carInfo.id
            this.roomInfo.car_name = carInfo.name
            this.roomInfo.company_name = carInfo.user?.company_name || ''
            this.roomInfo.contact_code = carInfo.contact_code || ''
            /* eslint-enable */
          }

          this.currentPage = apiResponse?.data?.current_page
          this.canNext = !!apiResponse?.data?.next_page_url
          this.restoreScrollPosition()
        }
        this.isCallingApi = false

        return apiResponse
      }
    },
    async getFirstPage() {
      if (this.roomInfo?.id) {
        this.canNext = true
        this.currentPage = 0
        this.listItems = []
        this.previousScrollHeight = 0
        this.activeScroll = false
        this.show()

        await this.paging()
        this.scrollToBottom()
        this.clearTimeout()
        this.setUpTimeout()
        this.$nextTick(() => {
          setTimeout(() => {
            this.activeScroll = true
          }, 300)
        })
      }
    },
    getList(page = 1) {
      page = page > 1 ? page : 1
      return this.$api.getChatMessage(this.roomInfo?.id, { page: page })
    },
    onScroll() {
      if (!this.activeScroll) {
        return false
      }
      const dom = this.$refs.list
      if (!dom) {
        return false
      }
      const limitTopOffset = 150
      const hasScrollBar = dom.clientHeight < dom.scrollHeight
      const triggerLoadMore = dom.scrollTop <= limitTopOffset && hasScrollBar
      // scroll to top : load older message
      if (triggerLoadMore) {
        this.paging()
      }
    },
    scrollToBottom() {
      this.$nextTick(() => {
        const container = this.$refs.list
        if (!container) {
          return
        }
        container.scrollTop = container.scrollHeight
      })
    },
    addMessage(message, isCloud = true) {
      const mess = this.listItems.find(item => {
        return item.id === message.id
      })
      if (!mess) {
        message.isCloud = isCloud
        this.listItems.push(message)
      } else {
        mess.isCloud = isCloud
      }
    },
    async sendMessage(event) {
      if (this.isCallingApi) {
        return
      }

      const formData = new FormData()
      if (this.images.length > 0) {
        for (let i = 0; i < this.images.length; i++) {
          let file = this.images[i]
          formData.append('file[' + i + ']', file)
        }
      }
      if (this.content) {
        formData.append('content', this.content)
      }
      this.isCallingApi = true
      this.scrollToBottom()
      this.content = ''
      this.images = []
      await this.$api.sendMessage(
        this.roomInfo.id,
        formData,
        success => {
          this.addNewMessages(success.data)
          this.scrollToBottom()
        },
        error => {
          Toast.error(error.error[Object.keys(error.error)[0]])
        }
      )
      this.isCallingApi = false
    },
    onChangeFile(e) {
      this.images = []
      let selectedFiles = e.target.files
      for (let i = 0; i < selectedFiles.length; i++) {
        this.images.push(selectedFiles[i])
      }
    },
    onClickChooseFile() {
      this.$refs.inputFile.value = ''
      this.$refs.inputFile.click()
    },
    saveScrollPosition() {
      const container = this.$refs.list
      if (!container) {
        return
      }
      this.previousScrollHeight = container.scrollHeight - container.scrollTop
    },
    restoreScrollPosition() {
      this.$nextTick(() => {
        const container = this.$refs.list
        if (!container) {
          return
        }
        container.scrollTop = container.scrollHeight - this.previousScrollHeight
        // window.scrollTo(0, container.scrollHeight - this.previousScrollHeight)
      })
    },
    onWindowResize() {
      const WINDOW_WIDTH = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
      this.isMobileScreen = WINDOW_WIDTH < 768
    },
    show() {
      this.isShow = true
      this.oldIsShow = true
      this.$emit('show')
    },
    hide() {
      this.isShow = false
      this.oldIsShow = false
      this.$emit('hide')
    },
    deleteImage(image) {
      this.images.splice(image, 1)
    },
    addNewMessages(messages) {
      messages.forEach(newMessage => {
        this.addMessage(newMessage, false)
      })
    },
    makeImageUrl(image) {
      return URL.createObjectURL(image)
    },
  },
}
</script>
<style scoped>
.chat-detail-mobile {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9999;
}
</style>
