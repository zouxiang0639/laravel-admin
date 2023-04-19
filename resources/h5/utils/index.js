/**
 * 组装文件url
 * @param {string} url
 */
export function getFilePath(url) {

  //return  process.env.MIX_APP_URL + '/uploads/' + url
  return process.env.FILE_URL + url
}
