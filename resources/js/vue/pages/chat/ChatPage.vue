<template>
  <div class="flex flex-col md:flex-row md:gap-8 h-full bg-slate-200">
    <div class="w-full md:w-96 bg-white" style="height: 100%; min-width: 24rem">
      <div class="grid grid-cols-2 lg:flex text-slate-700 text-sm">
        <a
          class="text-center block py-1 lg:py-2 w-full cursor-pointer border-r"
          :class="{
            'bg-white': tab == $config.TYPE_SELLER,
            'bg-slate-200 opacity-50': tab != $config.TYPE_SELLER,
          }"
          @click.prevent="
            tab = $config.TYPE_SELLER
            loadTabChatWithBuyer = true
          "
        >
          購入
        </a>
        <a
          class="text-center block py-1 lg:py-2 w-full cursor-pointer border-r"
          :class="{
            'bg-white': tab == $config.TYPE_BUYER,
            'bg-slate-200 opacity-50': tab != $config.TYPE_BUYER,
          }"
          @click.prevent="
            tab = $config.TYPE_BUYER
            loadTabChatWithSeller = true
          "
        >
          販売
        </a>
        <!--        <a-->
        <!--          class="text-center block py-1 lg:py-2 w-full cursor-pointer"-->
        <!--          :class="{-->
        <!--            'bg-white': false,-->
        <!--            'bg-slate-200 opacity-50': true,-->
        <!--          }"-->
        <!--        >-->
        <!--          売り手側-->
        <!--        </a>-->
      </div>
      <chat-list
        v-if="loadTabChatWithBuyer"
        key="tab-chat-with-buyer"
        :class="{ hidden: tab != $config.TYPE_SELLER }"
        type="1"
        :current-id="currentRoomId"
        @selected="onSelectedChatList"
      ></chat-list>
      <chat-list
        v-if="loadTabChatWithSeller"
        key="tab-chat-with-seller"
        :class="{ hidden: tab != $config.TYPE_BUYER }"
        type="2"
        :current-id="currentRoomId"
        @selected="onSelectedChatList"
      ></chat-list>
    </div>
    <chat-detail :room-info="room" @hide="onChatDetailHide"></chat-detail>
  </div>
</template>
<script>
import ChatList from '../../components/chat/ChatList'
import ChatDetail from '../../components/chat/ChatDetail'
import debounce from 'lodash.debounce'

export default {
  name: 'ChatPage',
  components: { ChatList, ChatDetail },
  data() {
    return {
      tab: this.$config.TYPE_SELLER,
      room: null,
      loadTabChatWithSeller: false,
      loadTabChatWithBuyer: false,
      currentRoomId: 0,
      activeRoomId: 0,
    }
  },
  created() {
    this.debounceResize = debounce(this.onWindowResize, 200, { leading: true })
    window.addEventListener('resize', this.debounceResize)
    this.onWindowResize()

    this.activeRoom()
  },
  methods: {
    onSelectedChatList(roomInfo) {
      this.room = roomInfo
      this.currentRoomId = roomInfo.id
    },
    onChatDetailHide() {
      this.room = null
      this.currentRoomId = null
    },
    onWindowResize() {
      this.$nextTick(() => {
        const WINDOW_HEIGHT = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight
        let breadcrumbToTop = this.$el.getBoundingClientRect().top + window.scrollY
        let heightBoxChat = WINDOW_HEIGHT - breadcrumbToTop

        this.$el.style.height = heightBoxChat + 'px'
        document.querySelector('footer')?.remove()
        // document.querySelector('.footer_mobile')?.remove()
        document.querySelector('body')?.classList.add('overflow-hidden')
      })
    },
    activeRoom() {
      const roomId = this.$getQueryString('chat_room_id')
      const tab = this.$getQueryString('tab')
      if (roomId) {
        this.currentRoomId = roomId
        this.room = { id: roomId, car_name: '' }
      }

      if (tab == this.$config.TYPE_BUYER) {
        this.loadTabChatWithSeller = true
        this.tab = tab
      } else {
        this.loadTabChatWithBuyer = true
        this.tab = this.$config.TYPE_SELLER
      }
    },
  },
}
</script>

