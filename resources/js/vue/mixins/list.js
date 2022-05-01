export default {
  data() {
    return {
      isCallingApi: false,
      listItems: [],
      canNext: true,
      currentPage: 0,
    }
  },
  methods: {
    async paging() {
      if (this.isCanNext()) {
        this.isCallingApi = true
        const apiResponse = await this.paginationApi()

        if (apiResponse) {
          const listItems = apiResponse?.data?.data ?? []
          listItems.forEach(item => {
            this.listItems.push(item)
          })

          this.currentPage = apiResponse?.data?.current_page
          this.canNext = !!apiResponse?.data?.next_page_url
        }
        this.isCallingApi = false

        return apiResponse
      }
    },
    isCanNext() {
      return this.canNext && !this.isCallingApi && typeof this.paginationApi === 'function'
    },
  },
}
