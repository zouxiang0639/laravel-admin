import request from '@h5/utils/request'

export function captcha(key) {
  return request({
    url: process.env.H5_API + '/captcha/api/giftCard?'+key,
    method: 'get'
  })
}
