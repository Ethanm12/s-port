export function processMeta(data) {
    var processed = applyDefaults(data);

    const meta = [];
    const script = [];

    Object.keys(processed.name).forEach(name => {
        meta.push({
            name,
            vmid: name,
            content: processed.name[name]
        })
    })

    Object.keys(processed.property).forEach(property => {
        meta.push({
            property,
            vmid: property,
            content: processed.property[property]
        })
    });

    if ( processed.schema ) {
        script.push({
            type: 'application/ld+json',
            json: processed.schema
        });
    }

    const result = {
        meta,
        script
    }

    if (processed.title) {
        result.title = processed.title;
    }

    if (processed.titleTemplate) {
        result.titleTemplate = processed.titleTemplate.replace('%t', processed.siteName);
    }

    return result;

}

function applyDefaults(data) {
    var defaults = {
        name: {
            "twitter:card": "summary"
        },
        property: {
            "og:type": "website"
        }
    };

    defaults.name.title = data.title || (typeof document !== 'undefined' && document.title);
    defaults.name["twitter:title"] = defaults.name.title;
    defaults.property["og:title"] = defaults.name.title;


    if (data.description) {
        defaults.name.description = data.description;
        defaults.name['twitter:description'] = data.description;
        defaults.property['og:description'] = data.description;
    } 

    if (data.image) {
        defaults.name["twitter:image"] = data.image;
        defaults.property['og:image'] = data.image;
        if (data.imageAlt) {
            defaults.name["twitter:image:alt"] = data.imageAlt;
            defaults.property['og:image:alt'] = data.imageAlt;
        } else {
            console.warn('Meta image property sepcified without image alt');
        }
    }

    if (data.siteName) {
        defaults.property['og:site_name'] = data.siteName;
        defaults.titleTemplate = '%s | %t';
    }

    if (data.schema) {
        defaults.schema = {
            "@context": "https://schema.org/"
        };
        //TODO: MAybe we do want this?
        // if (data.description) defaults.schema.description = data.description;
        // if (data.image) defaults.schema.image = data.image;
    }

    return deepMerge(defaults, data);
}


function deepMerge(target, source) {
    if (!source) return target;
    if (typeof source !== 'object' || typeof target !== 'object') {
        throw new Error("Parameters must be objects");
    }
    var sourceKeys = Object.keys(source);
    sourceKeys.forEach(key => {
        if (typeof source[key] === 'object' && typeof target[key] === 'object') {
            deepMerge(target[key], source[key]);
        } else {
            target[key] = source[key];
        }
    });
    return target;
}
