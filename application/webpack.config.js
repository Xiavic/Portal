const path = require('path');

module.exports = {
    mode: "development",
    entry: [
        'jquery',
        './src/index.js',
    ],
    watchOptions: {
        ignored: './node_modules/'
    },
    output: {
        path: path.resolve(__dirname, 'dist/build'),
        filename: "[name].js"
    },
    devtool: "source-map",
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    "style-loader",
                    "css-loader",
                    "sass-loader"
                ]
            },
            {
                test: /\.(png|svg|jpg|gif)$/,
                use: {
                    loader:'file-loader',
                    options: {
                        name: "images/[name].[hash].[ext]",
                        publicPath: './build/'
                    }
                }
            }
        ]
    }
}