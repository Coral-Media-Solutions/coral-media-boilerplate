let Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

let baseDir = './src/CoralMedia/Bundle/WebDesktopBundle/Resources/'

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', baseDir + 'public/app.js')
    .copyFiles({
            from: baseDir + 'public/desktop',
            // to: 'desktop/[path][name].[hash:8].[ext]'
            to: 'desktop/[path][name].[ext]'
        }
    )
    .copyFiles({
            from: baseDir + 'public/ext-3.4.1',
            // to: 'ext-3.4.1/[path][name].[hash:8].[ext]'
            to: 'ext-3.4.1/[path][name].[ext]'
        }
    )
    .copyFiles({
            from: baseDir + 'public/requirejs',
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

module.exports = Encore.getWebpackConfig();
