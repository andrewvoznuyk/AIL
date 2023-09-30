import React, { useContext, useEffect, useState } from "react";
import { Breadcrumbs, Button, Card, CardActions, CardContent, CardMedia, Link, Paper, Typography } from "@mui/material";
import { NavLink } from "react-router-dom";
import { AppContext } from "../../App";
import {myMY} from "@mui/material/locale";

const FlightsItem = ({ flight }) => {
  const { authenticated } = useContext(AppContext);

  const getDate = (date) => {
    const arr = date.toString().split(".");

    return arr[0];
  };
  let myTimeDeparture=flight.fromLocation.departureTimeZone/3600;
  let myTimeArrival=flight.toLocation.arrivalTimeZone/3600;
  return (
    <Card
      sx={{ maxWidth: 400 }} style={{
      color: "black",
      margin: 10,
      marginTop: 30,
      boxShadow: 25,
      padding: 10,
      border: 2,
      borderColor: "grey",
      borderStyle: "solid"
    }}
    >
      <CardContent>
        <Typography gutterBottom variant="h5" component="div">
          From: {flight.fromLocation.name}
        </Typography>
        <Typography gutterBottom variant="h5" component="div">
          To: {flight.toLocation.name}
        </Typography>
        <Typography variant="body2" color="black">
          Distance: {flight.distance} km
        </Typography>
        <Typography variant="body2" color="black">
          Model: {flight.aircraftModel}
        </Typography>
        <Typography variant="body2" color="black">
          Number: {flight.aircraftNumber}
        </Typography>
        <Typography variant="body2" color="black">
          Departure: {getDate(flight.departure.date)} {" UTC " + (myTimeDeparture < 0 ?  myTimeDeparture :  "+" + myTimeDeparture)}
        </Typography>
        <Typography variant="body2" color="black">
          Arrival: {getDate(flight.arrival.date)} {" UTC " + (myTimeArrival < 0 ?  myTimeArrival :  "+" + myTimeArrival)}
        </Typography>
      </CardContent>
      <CardActions>
        <Button
          style={{ color: "white", backgroundColor: "black", padding: 10 }}
          to={authenticated ? `/flight/${flight.id}/buy` : "/login"}
          component={NavLink}
        >Buy ticket now!
        </Button>
      </CardActions>
    </Card>
  );

};

export default FlightsItem;