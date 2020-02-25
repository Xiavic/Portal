const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');

module.exports = {
    entry: [
        'jquery',
        './src/index.js',
    ],
    plugins: [
        new CleanWebpackPlugin(),
        new ManifestPlugin()
    ],
    output: {
        path: path.resolve(__dirname, 'dist/build'),
        filename: "[name].[contenthash:8].js"
    },
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