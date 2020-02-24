const path = require('path');

module.exports = {
    mode: "development",
    entry: "./src/index.js",
    watchOptions: {
        ignored: './node_modules/'
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
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
            }
        ]
    }
}