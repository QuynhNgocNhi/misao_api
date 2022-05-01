import CarManagerDetail from './pages/car_manager_detail'

require('./bootstrap')
import '@themesberg/flowbite'
import Common from './commons/common'
import Home from './pages/home'
import CarDetail from './pages/car_detail'
import CarManager from './pages/car_manager'
import CarList from './pages/car_list'
import Blog from './pages/blog'
import lozad from 'lozad'
import Toast from './commons/notyf'
import SearchHistory from './pages/search_history'
import BlogDetail from './pages/blog_detail'
import OrderBuyList from './pages/order_buy_list'
import NotificationList from './pages/notification_list'

$(function () {
  Common.init()
  Home.init()
  CarDetail.init()
  CarManager.init()
  CarList.init()
  Blog.init()
  BlogDetail.init()
  SearchHistory.init()
  CarManagerDetail.init()
  OrderBuyList.init()
  NotificationList.init()
})
window.lozad = lozad
window.Toast = Toast
