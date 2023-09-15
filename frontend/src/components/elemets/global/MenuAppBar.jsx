import * as React from "react";
import AppBar from "@mui/material/AppBar";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import IconButton from "@mui/material/IconButton";
import MenuIcon from "@mui/icons-material/Menu";
import AccountCircle from "@mui/icons-material/AccountCircle";
import Switch from "@mui/material/Switch";
import FormControlLabel from "@mui/material/FormControlLabel";
import FormGroup from "@mui/material/FormGroup";
import MenuItem from "@mui/material/MenuItem";
import Menu from "@mui/material/Menu";
import { Button } from "@mui/material";
import eventBus from "../../../utils/eventBus";
import { NavLink, useNavigate } from "react-router-dom";
import { useContext } from "react";
import { AppContext } from "../../../App";

export default function MenuAppBar () {

  const navigate = useNavigate();
  const { authenticated } = useContext(AppContext);
  const [anchorEl, setAnchorEl] = React.useState(null);

  const handleMenu = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const goTo = (route) => {
    navigate(route);
    handleClose();
  }

  const handleClose = () => {
    setAnchorEl(null);
  };

  return (
    <Box sx={{ flexGrow: 1 }}>
      <AppBar position="static">
        <Toolbar>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
            AIL
          </Typography>
          {(
            <div>
              <IconButton
                size="large"
                aria-label="account of current user"
                aria-controls="menu-appbar"
                aria-haspopup="true"
                onClick={handleMenu}
                color="inherit"
              >
                <AccountCircle />
              </IconButton>
              <Menu
                id="menu-appbar"
                anchorEl={anchorEl}
                anchorOrigin={{
                  vertical: "top",
                  horizontal: "right"
                }}
                keepMounted
                transformOrigin={{
                  vertical: "top",
                  horizontal: "right"
                }}
                open={Boolean(anchorEl)}
                onClose={handleClose}
              >
                {!authenticated &&
                  <MenuItem onClick={() => goTo("login")}>Sign in</MenuItem>
                }
                {!authenticated &&
                  <MenuItem onClick={() => goTo("register")}>Sign up</MenuItem>
                }

                {authenticated &&
                  <MenuItem onClick={handleClose}>Profile</MenuItem>
                }
                {authenticated &&
                  <MenuItem
                    onClick={() => eventBus.dispatch("logout")}
                  >Logout</MenuItem>
                }
              </Menu>
            </div>
          )}
        </Toolbar>
      </AppBar>
    </Box>
  )
    ;
}