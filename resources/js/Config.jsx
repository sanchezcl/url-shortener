import axios from 'axios'
const base_api_url = import.meta.env.VITE_API_URL

export default {
    CreateUrl: `${base_api_url}/api/url`,
    GetUrls: `${base_api_url}/api/url`,
    DeleteUrl: `${base_api_url}/api/url`,
    RedirectPath: `${base_api_url}/u`

}
