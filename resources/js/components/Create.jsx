import react, {useState} from "react";
import Config from '../Config.jsx'
import { useNavigate } from 'react-router-dom'
import { useForm } from "react-hook-form";

const Create = () => {
    let serverError = "";

    const {
        register,
        handleSubmit,
        formState: { errors, isValid, isSubmitting }
    } = useForm({ defaultValues: {
            url: "",
        }
    });
    const [ apiError, setApiError ] = useState(null)
    const regEx = /^https?:\/\/?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
    const navigate = useNavigate()
    const onSubmit = handleSubmit(async(data)=>{
        setApiError(null)
        await axios.post(Config.CreateUrl, data)
            .then(response => {
                navigate("/")
            })
            .catch(err => {
                if (err.response.status === 400){
                    setApiError(err.response.data.error)
                } else {
                    setApiError("something went wrong!!!")
                    console.log(err)
                }

            })
    })

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-sm-5">
                    <div className="card mt-5 mb-5">
                        <div className="card-body">
                            <h1 className="text-center fw-bolder">Create short URL</h1>
                            <form onSubmit={onSubmit} noValidate>
                                <div className="form-group">
                                    <input
                                        {...register("url", {
                                            required: 'URL is required',
                                            pattern: {
                                                value: regEx,
                                                message: 'This is not a correct http url'
                                            }
                                        })
                                        }
                                        type="text"
                                        name="url"
                                        className="form-control mt-3"
                                        placeholder="https://www.example.com" />
                                    {errors.url && <span className="help-block">{errors.url.message}</span>}
                                </div>
                                <button type="submit" disabled={!isValid || isSubmitting} className="btn btn-primary w-100 mt-3">Send</button>
                                <p>{apiError}</p>
                            </form>
                            {serverError && <span className="help-block">{serverError}</span>}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Create
