if (process.env.SERVER) {
    require('./webpack.mix.server');
} else {
    require('./webpack.mix.client');
}