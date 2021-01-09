import axios from 'axios';

const cmsUrl =`${CMSURI}api/`;

/**
 * Abstraction layer around CMS fetching.
 * If new ways of querying the CMS are needed, they 
 * should be implemented here, with attention paid to 
 * ensure they have the ability to synchronously read
 * from the cache if it is present. 
 */
export default {

    getCollection(collectionName) {
        return axios.get(`${cmsUrl}${collectionName}`).then(d => d.data);
    },

    getPage(pageName) {
        return axios.get(`${cmsUrl}pages/${pageName}`).then(d => d.data);
    }
}