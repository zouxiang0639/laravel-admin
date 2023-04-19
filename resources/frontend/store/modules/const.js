import {getItem} from '@f/api/system/const'

const state = {
  tagsType: {},
  systemLogType: {},
}

const mutations = {
  SET_ROLES: (state, type) => {
    for (let key in type) {
      switch (key) {
        case 'tagsType':
          state.tagsType = type[key]
          break;
        case 'systemLogType':
          state.systemLogType = type[key]
          break;
      }
    }
  },
}

const actions = {

  // 系统常量-获取
  getItem({commit, state}, type) {
    return new Promise((resolve, reject) => {
      getItem({type: type}).then(response => {
        const {data} = response

        commit('SET_ROLES', data)
      }).catch(error => {
        reject(error)
      })
    })
  },

}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
