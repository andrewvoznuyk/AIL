import React, { useContext, useEffect, useState } from "react";
import axios from "axios";
import UserAuthenticationConfig from "../../utils/userAuthenticationConfig";
import { AppContext } from "../../App";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import { responseStatus } from "../../utils/consts";
import Notification from "../elemets/notification/Notification";
import { Box, Button, Grid, Input, TextField, Typography } from "@mui/material";
import GlobalRegistrationItems from "../registration/GlobalRegistrationItems";
import InputCustom from "../elemets/input/InputCustom";
import InputPhoneNumber from "../elemets/input/InputPhoneNumber";
import InputPassword from "../elemets/input/InputPassword";
import { Label } from "recharts";
import ModalConfirmEmail from "../elemets/modalForConfirm/ModalConfirmEmail";

const UpdateProfileContainer = () => {
  const { user } = useContext(AppContext);

  const [name, setName] = useState("");
  const [surname, setSurname] = useState("");
  const [phoneNumber, setPhoneNumber] = useState("");
  const [email, setEmail] = useState("");
  const [authData, setAuthData] = useState()

  const [initialFormValues, setInitialFormValues] = useState({
    name: "",
    surname: "",
    phoneNumber: "",
    email: "",
  });

  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const [modalOpen, setModalOpen] = useState(false);
  const [isEmailConfirmed, setIsEmailConfirmed] = useState(false); // Додайте змінну для відстеження статусу підтвердження пошти


  const getUserInfo = ()=>{
    axios.get("/api/username",
      userAuthenticationConfig()).then((response) => {
      setName(response.data.name);
      setSurname(response.data.surname);
      setPhoneNumber(response.data.phoneNumber);
      setEmail(response.data.email);
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    });
  }

  const handleSubmit = (event) => {
    event.preventDefault();

    const data = {
      email: email,
      name: name,
      surname: surname,
      phoneNumber: phoneNumber
    };

    setAuthData(data);

    axios.post("/api/confirm-email", data).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        setIsEmailConfirmed(true);
        setModalOpen(true);
      }
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.detail });
    });
  };

  const handleCloseModal = () => {
    setModalOpen(false);
    setIsEmailConfirmed(false);
  };

  const updateUser = () => {

    if (!authData) {
      return;
    }

    setLoading(true);

    if (!isEmailConfirmed) {
      setNotification({ ...notification, visible: true, type: "error", message: "Email is not confirmed" });
      setLoading(false);
      return;
    }

    axios.put("/api/update-user", authData, UserAuthenticationConfig())
    .then((response) => {
      setNotification({ ...notification, visible: true, type: "success", message: "Profile was updated! " });
    })
    .catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    }).finally(() => {
      setLoading(false);
      setModalOpen(false);
    });



  };

  // useEffect(() => {
  //   updateUser();
  // }, [authData]);

  useEffect(() => {
    getUserInfo()
  }, []);

  return (
    <>
      {notification.visible &&
        <Notification notification={notification} setNotification={setNotification} />
      }
      <form className="auth-form" onSubmit={handleSubmit} style={{ width: "300px" }}>
        <h2>Update your profile</h2>

        <TextField
          label="Name: "
          variant="outlined"
          value={name}
          onChange={(e)=>setName(e.target.value)}
          required
        />

        <TextField
          id="surname"
          type="text"
          label="Surname"
          name="surname"
          value={surname}
          onChange={(e)=>setSurname(e.target.value)}
          required
        />

        <TextField
          id="email"
          type="email"
          label="E-mail"
          name="email"
          value={email}
          // onChange={(e)=>setEmail(e.target.value)}
          // required
          disabled
        />

        <TextField
          id="phoneNumber"
          label="Phone Number"
          name="phoneNumber"
          value={phoneNumber}
          onChange={(e)=>setPhoneNumber(e.target.value)}
          required
        />
        <Button
          variant="contained"
          type="submit"
          disabled={loading}
        >
          Save changes
        </Button>
      </form>

      <ModalConfirmEmail
        open={modalOpen}
        onClose={() => setModalOpen(false)}
        onConfirm={updateUser}
        onNotMyEmail={handleCloseModal}
      />
    </>
  );

}

export default UpdateProfileContainer;