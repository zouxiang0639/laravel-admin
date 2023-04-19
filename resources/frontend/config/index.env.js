'use strict'
if(process.env.NODE_ENV == 'production') {
  module.exports = require('./production.env')
} else {
  module.exports = require('./development.env')
}

