module.exports = {
  devServer: {
        proxy: 'http://myfinance.loc/',
        public: '192.168.10.1:8080/'
    },
  // proxy API requests to Valet during development
  

  // output built static files to Laravel's public dir.
  // note the "build" script in package.json needs to be modified as well.
  outputDir: '../public',

  // modify the location of the generated HTML file.
  // make sure to do this only in production.
  indexPath: process.env.NODE_ENV === 'production'
    ? '../resources/views/index.blade.php'
    : 'index.html',

  configureWebpack: {
    devServer: {
        watchOptions: {
          ignored: ['node_modules'],
          aggregateTimeout: 300,
          poll: 1500
        },
        public: '192.168.10.1' // vagrant machine address
    }
  }
}