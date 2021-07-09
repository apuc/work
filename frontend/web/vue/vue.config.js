module.exports = {
    // настройки...
    devServer: {
        //proxy: 'http://work.loc',
        proxy: `${process.env.VUE_APP_API_URL}`,
        watchOptions: {
            poll: true,
        },
    }
    // publicPath: '/work.loc'
    // devServer: {
        // host: 'http://work.loc',
        // port: '81'
        // https: true
        // proxy: {
        //     '/work.loc/request': {
        //         target: 'http://127.0.0.1:80'
        //     },
        // }
    // },
};