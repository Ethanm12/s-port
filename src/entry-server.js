// This must be the first import so that all console logs caused
// by later imports do not mess up the rendering. Also a site for
// any other code that must be executed before imports, like setting CMSURI
import './utils/sanitise-server';
import { createApp } from './app';
import { createRenderer } from 'vue-server-renderer';

if (process.env.SECURE  && !process.env.NODE_ENV !== 'production') {
    var rootCas = require('ssl-root-cas/latest').create();
    rootCas.addFile(process.env.HOME + '/.config/valet/CA/LaravelValetCASelfSigned.pem');
 
    // default for all https requests
    // (whether using https directly, request, or another module)
    require('https').globalAgent.options.ca = rootCas;
}

const renderer = createRenderer({
    template: '<!--vue-ssr-outlet-->'
});
const context = JSON.parse(process.argv[2]);
const { initApp, router, store } = createApp();
const app = initApp();
const meta = app.$meta();
const delimiter = `__SSR_OUTLET_META_DELIMETER_${context.delimiter_hash}__`

router.push(context.url);
context.meta = meta;

router.onReady(() => {
    context.rendered = () => {
        // After the app is rendered, our store is now
        // filled with the state from our components.
        // When we attach the state to the context, and the `template` option
        // is used for the renderer, the state will automatically be
        // serialized and injected into the HTML as `window.__INITIAL_STATE__`.
        context.state = store.state
      }
    renderer.renderToString(app, context, (err, html) => {
        if (err) {
            throw err;
        }
        const metaHead = context.meta.inject();
        dispatch(metaHead.meta.text());
        dispatch(metaHead.title.text());
        dispatch(metaHead.link.text());
        dispatch(metaHead.script.text());
        dispatch(metaHead.noscript.text());
        dispatch(delimiter);
        dispatch(html);
    });
});
