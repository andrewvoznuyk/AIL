import {Helmet} from "react-helmet-async";
import {NavLink} from "react-router-dom";
import {Button, ButtonGroup, Typography} from "@mui/material";
import {useContext} from "react";
import {AppContext} from "../../App";
import eventBus from "../../utils/eventBus";
import PlaneSelectForm from "../../components/planeSelect/PlaneSelectForm";

const HomePage = () => {
    const {authenticated} = useContext(AppContext);

    return (
        <>
            <Helmet>
                <title>
                    Welcome
                </title>
            </Helmet>
            <div style={{textAlign: "center"}}>
                <Typography variant="h3" component="h1" mb={3}>
                    Welcome!
                </Typography>
                <ButtonGroup variant="contained" aria-label="outlined primary button group">
                    <Button
                        to={authenticated ? "/panel/goods" : "/login"}
                        component={NavLink}
                    >
                        {authenticated ? "Goods" : "Sign in"}
                    </Button>

                    {!authenticated &&
                        <Button
                            variant="outlined"
                            to="register"
                            component={NavLink}
                        >
                            Sign up
                        </Button>
                    }

                    {authenticated &&
                        <Button
                            variant="outlined"
                            onClick={() => eventBus.dispatch("logout")}
                            component={NavLink}
                        >
                            Log out
                        </Button>
                    }
                </ButtonGroup>
                <PlaneSelectForm/>
            </div>
        </>
    );
};

export default HomePage;