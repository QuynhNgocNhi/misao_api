import BaseApi from './base_api'
import { axiosClient } from '../../commons/axiosClient'

export default class Api extends BaseApi {
  postLogin(data, success, error) {
    return this.post('login', data, success, error)
  }

  postPasswordEmail(data, success, error) {
    return this.post('password/email', data, success, error)
  }

  postPasswordReset(data, success, error) {
    return this.post('password/reset', data, success, error)
  }

  postRegister(data, success, error) {
    return this.post('register', data, success, error)
  }

  postOrderRequest(data, success, error) {
    return this.post('order/request', data, success, error)
  }

  postOrderUpdateStatus($orderId, data, success, error) {
    return this.post('order/update-status/' + $orderId, data, success, error)
  }

  storeCar(params) {
    return axiosClient.post('/car-manager/store', params)
  }

  updateCar($id, params) {
    return axiosClient.post('/car-manager/update/' + $id, params)
  }

  uploadMedia(params) {
    return axiosClient.post('/car-media/upload', params)
  }

  updatePhotoPosition(params) {
    return axiosClient.post('/car-media/update-photo-position', params)
  }

  postContactRequest(data, success, error) {
    return this.post('contact/request', data, success, error)
  }

  getChatRoom(data, success, error) {
    return this.get('chat/room', data, success, error)
  }

  getChatMessage(id, data, success, error) {
    return this.get('chat/room/' + id + '/message', data, success, error)
  }

  sendMessage(id, data, success, error) {
    return this.post('chat/room/' + id + '/message', data, success, error)
  }

  postUpdatePassword(data, success, error) {
    return this.post('account/update-password', data, success, error)
  }

  // end front end
  // admin
  getAdminChatMessage(id, data, success, error) {
    return this.get('admin/chat/room/' + id + '/message', data, success, error)
  }

  storeCarAdmin(params) {
    return axiosClient.post('/admin/cars/store', params)
  }

  uploadMediaAdmin(params) {
    return axiosClient.post('/admin/car-media/upload', params)
  }

  updatePhotoPositionAdmin(params) {
    return axiosClient.post('/admin/car-media/update-photo-position', params)
  }

  updateCarAdmin($id, params) {
    return axiosClient.post('/admin/cars/update-car/' + $id, params)
  }

  approveCar(params) {
    return axiosClient.post('/admin/car-approve/update-approve', params)
  }

  // end admin
}
