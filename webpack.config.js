const path = require('path')

module.exports = {
  output: {
    chunkFilename: '[name].[contenthash:8].js',
  },
  resolve: {
    extensions: ['.js', '.vue'],
    alias: {
      // vueファイルのimport先のエイリアス
      '@': path.resolve(__dirname, './resources/js'),
    },
  },
}
