import request from '@f/utils/request'

export function getItem(data) {
  return request({
    url: process.env.H5_API + '/system/const/getItem',
    method: 'post',
    data
  })
}



