export default class BaseApi {
  constructor(axios, log) {
    this.api = axios
    this.logger = log
    this.prefix = '/'
  }

  processResponse(response) {
    const data = response
    // eslint-disable-next-line no-prototype-builtins
    if (data.hasOwnProperty('data')) {
      return data.data
    }

    return data
  }

  processError(e, error) {
    this.logger?.error(e?.response)
    if (error !== undefined && e.response !== undefined) {
      // eslint-disable-next-line no-prototype-builtins
      if (e.response.hasOwnProperty('status')) {
        const errorMessage = {}
        if (e.response.status === 422) {
          const errors = e.response?.data?.errors
          Object.keys(errors).forEach(function (key) {
            errorMessage[key] = errors[key][0]
          })
        }
        // eslint-disable-next-line
        if ([200, 422].indexOf(e.response.status) === -1) {
          errorMessage.error = e.response?.data?.message
        }
        error({
          code: e.response.status,
          error: errorMessage,
        })
      }
    }
  }

  request(method, endpoint, data, success, error) {
    method = method.toLowerCase()
    const config = {
      url: encodeURI(endpoint),
      method,
    }
    if (method === 'get') {
      config.params = data
    } else {
      config.data = data
    }
    return this.api
      .request(config)
      .then(response => this.processResponse(response))
      .then(json => {
        if (typeof success === 'function') {
          success(json)
        }
        return json
      })
      .catch(e => {
        this.processError(e, error)
      })
  }

  get(endpoint, query, success, error) {
    return this.request('get', this.prefix + endpoint, query, success, error)
  }

  post(endpoint, data, success, error) {
    return this.request('post', this.prefix + endpoint, data, success, error)
  }

  put(endpoint, data, success, error) {
    return this.request('put', this.prefix + endpoint, data, success, error)
  }

  delete(endpoint, data, success, error) {
    return this.request('delete', this.prefix + endpoint, data, success, error)
  }

  urlParse(obj) {
    const str = []
    // eslint-disable-next-line no-prototype-builtins
    // eslint-disable-next-line
    for (const p in obj)
      // eslint-disable-next-line
      if (obj.hasOwnProperty(p)) {
        str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]))
      }
    return str.join('&')
  }
}
