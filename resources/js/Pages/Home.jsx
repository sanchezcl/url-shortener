import React, {useEffect, useState} from 'react'
import { FaTrashAlt, FaRocket } from "react-icons/fa";
import Config from "../Config.jsx";

const Home = () => {
    const [urls, setUrls] = useState([])
    const [error, setError] = useState()
    const [flashRedirect, setFlashRedirect] = useState(false)
    useEffect(()=> {
        getUrls();
    }, []);

    const getUrls = async () =>{
        try {
            const response = await axios.get(Config.GetUrls)
            setUrls(response.data)
        } catch (e) {
            setError(e)
        }
    }

    const handleDelete = async (idx) => {
        try {
            const response = await axios.delete(Config.DeleteUrl + `/${idx}`)
            getUrls()
        } catch (e) {
            setError(e)
        }
    }

    const handleRedirect = async (idx) => {
        setFlashRedirect(true)
        setTimeout( () => {
            window.open(Config.RedirectPath + `/${idx}`)
            setFlashRedirect(false)
        }, 1000)

    }

    return (
        <div className="container bg-light" >
            <div className="row mt-3">
                <div className="card">
                    <div className="card-body">
                        { flashRedirect && <div className="alert alert-primary" role="alert">Redirecting...</div>}
                        <table className="table">
                            <thead>
                                <tr>
                                    <th>Id</th><th>Url</th><th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    !urls.data ? <tr key="loading"><td>"...loading"</td></tr> : urls.data.map(
                                        (url)=>{
                                            return (
                                                <tr key={url.url_id}>
                                                    <td>{url.url_id}</td>
                                                    <td>{url.url}</td>
                                                    <td>
                                                        <button className="btn" onClick={e => handleDelete(url.url_id, e)}>
                                                            <FaTrashAlt />
                                                        </button>
                                                        <button className="btn">
                                                            <FaRocket onClick={e => handleRedirect(url.url_id)}/>
                                                        </button>
                                                    </td>
                                                </tr>
                                            )
                                    })
                                }
                            </tbody>
                        </table>
                        {/*<nav aria-label="Page navigation example">
                            <ul className="pagination">
                                <li className={"page-item " + (urls.links?.prev ? "" : "disabled")}>
                                    <a className="page-link" href="#" >Previous</a>
                                </li>
                                <li className={"page-item " + (urls.links?.next ? "" : "disabled")}>
                                    <a className="page-link" href="#" >Next</a>
                                </li>
                            </ul>
                        </nav>*/}
                        {error && <span className="help-block">Something went wrong!</span>}
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Home
