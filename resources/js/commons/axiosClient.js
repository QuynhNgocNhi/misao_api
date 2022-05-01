import axios from "axios";

const configDefault = {
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  }
}
export const axiosClient = {
  get(url, params, configs) {
    return sendApi({
      method: 'get',
      url: url,
      params: params,
      ...configs
    });
  },
  post(url, data, configs) {
    return sendApi({
      method: 'post',
      url: url,
      data: data,
      ...configs
    });
  },
  put(url, data, configs) {
    return sendApi({
      method: 'put',
      url: url,
      data: data,
      ...configs
    });
  },
  delete(url, data, configs) {
    return sendApi({
      method: 'delete',
      url: url,
      data: data,
      ...configs
    });
  },
}

const sendApi = (settingConfigs) => {
  return new Promise((resolve, reject) => {
    axios({
      ...configDefault,
      ...settingConfigs
    }).then(response => {
      // console.log(JSON.stringify(response.data));
      resolve(response.data);
    }).catch(error => {
      redirectUnauthorized(error);
      reject(error.response);
    });
  });
}
const redirectUnauthorized = (error) => {
  if (error.response && error.response.status === 401) {
    window.location.href = '/401'
  }
}

export const serialize = params => {
  let queryString = Object.keys(params).map(filter => {
    if (params[filter] || Number.isInteger(params[filter])) {
      return `${filter}=${params[filter]}`;
    }
    return null;
  }).filter(item => item).join('&');
  if (queryString) {
    return '?' + queryString;
  }
  return '';
}
