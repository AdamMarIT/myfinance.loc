import store from './store'
console.log(store, 'store')
let baseURL = 'http://localhost:8080'

const getToken = store.state.accessToken

async function getRequest(url, method, data = {}) {
  let fetchUrl = baseURL + url
  
  let headers = {
    'Content-Type': 'application/json',
  }

  if (getToken) {
    headers = {
      'Authorization': `Bearer ${getToken}`,
      ...headers
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
        body: JSON.stringify(data), // тип данных в body должен соответвовать значению заголовка "Content-Type"
    })
    return await response.json();
    //.then(response => response.json()); // парсит JSON ответ в Javascript объект
}


const request = {
  get: async (url, options) => {
    let response = await getRequest(url, 'GET', options)
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
