import {useContext, useEffect, useState} from "react";
import {NavLink, useNavigate} from "react-router-dom";
import axios from "axios";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, Link, Typography} from "@mui/material";
import Notification from "../elemets/notification/Notification";
import {authentication} from "../../utils/authenticationRequest";
import {responseStatus} from "../../utils/consts";
import {AppContext} from "../../App";
import loginRequest from "../../utils/loginRequest";
import RegistrationForm from "./RegistrationForm";
import {storageSetItem, TOKEN} from "../../storage/storage";
import CreateFlightForm from "./CreateFlightForm";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";

const FlightContainer = () => {

    const [error, setError] = useState(null);
    const [requestData, setRequestData] = useState();
    const [loading, setLoading] = useState(false);
    const [notification, setNotification] = useState({
        visible: false,
        type: "",
        message: ""
    });

    const sendRequest = () => {

        if (!requestData) {
            return;
        }

        axios.post(`/api/flights`, requestData, userAuthenticationConfig(false)).then(response => {
            console.log(response);
            if (response.status === responseStatus.HTTP_CREATED) {
                setNotification({...notification, visible: true, type: "success", message: "Flight created!"});
            }
        }).catch(error => {
            setError(error.response.data.detail);
            setNotification({...notification, visible: true, type: "error", message: error.response.data.detail});
        }).finally(() => setLoading(false));
    }

    useEffect(() => {
        sendRequest();
    }, [requestData]);

    return (
        <>
            {notification.visible &&
                <Notification
                    notification={notification}
                    setNotification={setNotification}
                />
            }
            <Helmet>
                <title>
                    Create account
                </title>
            </Helmet>
            <CreateFlightForm
                setData={setRequestData}
                loading={loading}
            />
        </>
    );
};

export default FlightContainer;