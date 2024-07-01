/**
 * Adds the URL parameters from the URLSearchParams object to the URL.
 * @param {string} url - URL address.
 * @param {URLSearchParams} params - URLSearchParams object with URL parameters.
 * @returns {string} - Final URL with added parameters.
 */
export function addUrlParams(url, params) {
    const basicUrl = url.split('?')[0];
    if (Array.from(params.keys()).length === 0) {
        return basicUrl;
    } else {
        return `${basicUrl}?${params.toString()}`;
    }
}
