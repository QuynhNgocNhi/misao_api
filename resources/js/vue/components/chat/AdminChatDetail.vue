<template>
  <div v-if="listItems.length" class="flex-grow bg-slate-200">
    <div ref="list" class="chat-message-list relative" @scroll="debounceScroll">
      <div v-show="isCallingApi" class="text-center">
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
      <template v-for="(messages, date) in items">
        <p class="text-center text-xs">{{ date | moment('M月D日 (ddd)') }}</p>
        <template v-for="(message, i) in messages">
          <div
            class="d-flex mb-3"
            :class="{ 'justify-content-start': !message.self, 'justify-content-end': message.self }"
          >
            <div v-if="!message.self" class="d-inline-flex avatar mr-3">
              <div class="thumbnail">
                <img v-lozad="roomInfo.thumbnail" />
              </div>
            </div>
            <div class="d-inline-flex position-relative message p-3"
              :class="{ 'mr-2 message-seller': message.self, 'message-buyer': !message.self }">
              <div v-if="message.isImage"><img v-lozad="message.content" class="mw-100" /></div>
              <div v-else>{{ message.content }}</div>
              <span
                class="color-black position-absolute text-dark -bottom-0"
                :class="{ '-right-10': !message.self, '-left-10': message.self }"
              >
                {{ message.created_at | moment('hh:mm') }}
              </span>
            </div>
          </div>
        </template>
      </template>
    </div>
  </div>
</template>
<script>
import listMixin from '../../mixins/list'
import debounce from 'lodash.debounce'

export default {
  name: 'AdminChatDetail',
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
    }
  },
  computed: {
    items() {
      const messages =
        this.listItems?.reduce((messages, item) => {
          const createdAt = this.$moment(item.created_at).format('YYYY-MM-DD')
          if (item.seller_id) {
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
      return 'status'
    },
  },
  watch: {},
  beforeDestroy() {},
  async created() {
    this.debounceScroll = debounce(this.onScroll, 300, { leading: true })
    await this.getFirstPage()
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

      const apiResponse = await this.$api.getAdminChatMessage(this.roomInfo.id, { last_id: this.lastMessageId })
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
      console.log(this.roomInfo)
      if (this.roomInfo?.id) {
        this.canNext = true
        this.currentPage = 0
        this.listItems = []
        this.previousScrollHeight = 0
        this.activeScroll = false

        await this.paging()
        this.scrollToBottom()
        this.$nextTick(() => {
          setTimeout(() => {
            this.activeScroll = true
          }, 300)
        })
      }
    },
    getList(page = 1) {
      page = page > 1 ? page : 1
      return this.$api.getAdminChatMessage(this.roomInfo?.id, { page: page })
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

      if (event.target.files) {
        const file = event.target.files[0]
        const isImage = file['type'].split('/')[0] === 'image'
        if (!isImage) {
          Toast.error('image invalid')
          return
        }

        formData.append('file', file)
      } else {
        formData.append('content', this.content)
      }
      this.isCallingApi = true

      await this.$api.sendMessage(
        this.roomInfo?.id,
        formData,
        success => {
          this.addMessage(success.data, false)
          this.content = ''
          this.scrollToBottom()
        },
        error => {
          Toast.error(error?.error?.error)
        }
      )
      this.isCallingApi = false
    },
    onChangeFile(e) {
      this.sendMessage(e)
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
      })
    },
  },
}
</script>
<style scoped>
.chat-message-list {
  overflow-y: scroll;
  height: min(100vh, 600px);
}
.thumbnail {
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 100%;
  overflow: hidden;
}

.thumbnail img {
  height: 100%;
  -o-object-fit: cover;
  object-fit: cover;
  width: 100%;
}

.message {
  max-width: 28rem;
  color: white;
  --tw-bg-opacity: 1;
  background-color: rgba(19, 112, 227, var(--tw-bg-opacity));
  border-radius: 0.25rem;
}

.-right-10 {
  right: -2.5rem;
}

.-left-10 {
  left: -2.5rem;
}
.-bottom-0 {
  bottom: 0;
}
.message-buyer {
  color: rgb(255, 255, 255);
  background-color: #4d08f0;
}
.message-seller {
  color: rgb(0, 0, 0);
  background-color: rgb(233, 233, 233);
}
</style>
