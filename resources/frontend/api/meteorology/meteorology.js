import request from '@f/utils/request'

export function getMeteorology(data) {
  return request({
    url: process.env.API_URL + '/meteorology/getMeteorology',
    method: 'post',
    data
  })
}

export function getHome() {
  return request({
    url: process.env.API_URL + '/meteorology/getHome',
    method: 'get',
  })
}

export function getMeteorologyEquipment(id) {
  return request({
    url: process.env.API_URL + '/meteorology/getMeteorologyEquipment/'+id,
    method: 'get',
  })
}

export function getMapEquipment() {
  return request({
    url: process.env.API_URL + '/meteorology/getMapEquipment',
    method: 'get',
  })
}


