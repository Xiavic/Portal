const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');

module.exports = {
    entry: [
        'jquery',
        './src/index.js',
    ],
    plugins: [
        new CleanWebpackPlugin(),
        new WebpackManifestPlugin({
            publicPath: 'build'
        })
    ],
    output: {
        path: path.resolve(__dirname, 'dist/build'),
        assetModuleFilename: (pathData) => {
            const filepath = path
              .dirname(pathData.filename)
              .split("/")
              .slice(1)
              .join("/");
            return `${filepath}/[name].[hash][ext][query]`;
          },
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
                type: 'asset/resource'
            }
        ]
    }
}