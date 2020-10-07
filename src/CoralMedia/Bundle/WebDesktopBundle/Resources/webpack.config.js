let Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

let baseDir = './src/CoralMedia/Bundle/WebDesktopBundle/Resources/public/'

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', baseDir + 'app.js')
    .copyFiles({
        from: './node_modules/chart.js/dist',
        to: 'desktop/chart.js/[path][name].[ext]'
    })
    .copyFiles({
            from: baseDir + 'desktop',
            // to: 'desktop/[path][name].[hash:8].[ext]'
            to: 'desktop/[path][name].[ext]'
        }
    )
    .copyFiles({
            from: baseDir + 'ext-3.4.1',
            // to: 'ext-3.4.1/[path][name].[hash:8].[ext]'
            to: 'ext-3.4.1/[path][name].[ext]'
        }
    )
    .copyFiles({
            from: baseDir + 'requirejs',
            // to: 'ext-3.4.1/[path][name].[hash:8].[ext]'
            to: 'requirejs/[path][name].[ext]'
        }
    )
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
const webpackConfig = Encore.getWebpackConfig();

module.exports = webpackConfig;
