let streamFree = Promise.resolve();
let errorStreamFree = Promise.resolve();

global.dispatch = text => {
    streamFree = streamFree.then(() => {
        if (!process.stdout.write(text)) {
            return new Promise(r => process.stdout.once('drain', r));
        } else {
            return new Promise(r => process.nextTick(r));
        }
    })
}

global.dispatchError = error => {
    errorStreamFree = errorStreamFree.then(() => {
        if (!process.stderr.write(error.toString())) {
            return new Promise(r => process.stderr.once('drain', r));
        } else {
            return new Promise(r => process.nextTick(r));
        }
    })
}

global.console = {
    log: () => {},
    error: dispatchError,
    warn: () => {},
    dir: () => {}
}

const context = JSON.parse(process.argv[2]);
global.CMSURI = context.domain_root;
