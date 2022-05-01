<template>
  <div ref="list" class="flex flex-col overflow-y-auto pb-5" style="height: calc(100% - 50px)" @scroll="debounceScroll">
    <div
      v-for="(item, i) in items"
      class="flex border-b py-3 px-4 cursor-pointer relative"
      :class="{ 'cell-active': item.id && item.id == currentId, 'mb-6': i === items.length - 1 }"
      @click="onClickChatRoom(item, $event)"
    >
      <div class="avatar">
        <div class="w-14 h-14 border rounded-full">
          <img v-lozad="item.thumbnail" />
        </div>
      </div>

      <div class="ml-2 flex-grow">
        <div class="flex justify-between mb-1">
          <span class="text-sm font-medium">{{ item.company_name || '' }}</span>
          <span class="text-xs font-light"
            ><i v-if="!item.read_at" class="fas fa-circle text-red-600 mr-1"></i>{{ item.date }}</span
          >
        </div>
        <div class="pr-3">
          <p class="text-xs font-normal mb-1 whitespace-pre-wrap line-clamp-2">{{ item.message }}</p>
          <p class="text-xs text-gray-500">車両番号：{{ item.contact_code }}</p>
        </div>
      </div>
      <i class="fa fa-angle-right text-blue-500 absolute right-4 top-1/2 -tran-y-1/2"></i>
    </div>
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
  </div>
</template>
<script>
import listMixin from '../../mixins/list'
import debounce from 'lodash.debounce'

export default {
  name: 'ChatList',
  mixins: [listMixin],
  props: {
    type: {
      type: [Number, String],
      default: 1,
    },
    currentId: {
      type: [Number, String],
    },
  },
  data() {
    return {
      paginationApi: () => this.getList(this.currentPage + 1),
    }
  },
  computed: {
    items() {
      return this.listItems.map(item => {
        const date = new Date(item.created_at)
        return {
          id: item.id,
          thumbnail: item.order?.car?.thumb?.url || '',
          car_id: item.order?.car?.id,
          car_name: item.order?.car?.name,
          company_name: item.seller?.company_name || '',
          date: this.$moment(date).format('YYYY/MM/DD'),
          contact_code: item.order?.contact_code || '',
          message: item.last_message?.type === 1 ? '「写真」' : item.last_message?.content || '',
          read_at: this.type == 1 ? item.buyer_read_at : item.seller_read_at,
        }
      })
    },
  },
  async created() {
    this.debounceScroll = debounce(this.onScroll, 300, { leading: true })

    this.canNext = true
    await this.paging()

    this.$nextTick(() => {
      this.checkHasScroll()
    })
    this.$emit('loaded')
  },
  methods: {
    async paging() {
      if (this.isCanNext()) {
        this.isCallingApi = true
        const apiResponse = await this.paginationApi()

        if (apiResponse) {
          const listItems = apiResponse?.data?.data ?? []
          listItems.forEach(item => {
            this.addRoom(item)
          })

          this.currentPage = apiResponse?.data?.current_page
          this.canNext = !!apiResponse?.data?.next_page_url
        }
        this.isCallingApi = false

        return apiResponse
      }
    },
    addRoom(room) {
      const r = this.listItems.find(item => {
        return item.id === room.id
      })
      if (!r) {
        this.listItems.push(room)
      }
    },
    getList(page = 1) {
      page = page > 1 ? page : 1
      return this.$api.getChatRoom({ type: this.type, page: page })
    },
    onScroll() {
      const dom = this.$refs.list
      const viewportScrollTop = dom.scrollTop
      const viewportBottom = viewportScrollTop + dom.clientHeight
      const triggerLoadMore = dom.scrollHeight - viewportBottom <= 500

      if (triggerLoadMore) {
        this.paging()
      }
    },
    async checkHasScroll(count = 0) {
      if (count > 5) {
        return
      }
      const dom = this.$refs.list
      const hasScrollBar = dom.scrollHeight > dom.clientHeight

      if (!hasScrollBar && this.canNext) {
        await this.paging()
        this.$nextTick(() => {
          this.checkHasScroll(count + 1)
        })
      }
    },
    onClickChatRoom(item, $event) {
      this.$emit('selected', item)
    },
  },
}
</script>
<style scoped>
.cell-active {
  background: rgba(0, 0, 0, 0.1);
}
</style>
