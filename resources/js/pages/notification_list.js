var NotificationList = {
  init() {
    this.clearBadge()
  },
  clearBadge() {
    if (!window.location.href.includes('notification')) {
      return false
    }
    const perfEntries = performance.getEntriesByType('navigation')

    if (perfEntries[0].type === 'back_forward') {
      location.reload(true)
    }
  },
}
export default NotificationList
