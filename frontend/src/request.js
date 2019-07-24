import store from './store'

let baseURL = 'http://localhost:8080'


async function getRequest(url, method, data = {}) {
  let fetchUrl = baseURL + url
  const token = store.getters.getAccessToken;
  let headers = {}

  if (token) {
    headers = {
      'Authorization': `Bearer ${token}`,
      ...headers
    }
  }

  let postData = null
  
  if (data) {

    if (data.isFile) {
      postData = data.file 
    } else {
      postData = JSON.stringify(data)
      headers = {
        'Content-Type': 'application/json',
        ...headers
      }
    } 
  }

  // Значения по умолчанию обозначены знаком *
    let response =  await fetch(fetchUrl, {
        method: method, // *GET, POST, PUT, DELETE, etc.
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: headers,
        redirect: 'follow', // manual, *follow, error
        referrer: 'no-referrer', // no-referrer, *client
        body: postData, // тип данных в body должен соответвовать значению заголовка "Content-Type"
    })
    return await response.json();
    //.then(response => response.json()); // парсит JSON ответ в Javascript объект
}


const request = {
  get: async (url, options) => {
    let response = await getRequest(url, 'GET', options = "")
    return response
  },

  post: async (url, options) => {
    let response = await getRequest(url, 'POST', options)
    return response
  },

  install (Vue, options) {
    // if (options.baseURL) {
    //   befetch.baseURL = options.baseURL
    // }
    Vue.request = request
    Vue.prototype.$request = request
  }
}

export default request
