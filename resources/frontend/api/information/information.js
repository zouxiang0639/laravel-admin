import request from '@f/utils/request'

export function getInformation() {
  return request({
    url: process.env.API_URL + '/information/getList',
    method: 'post'
  })
}

export function destroyInformation(id) {

  return request({
    url: process.env.API_URL + '/information/destroy/' + id,
    method: 'delete'
  })
}



