import axios from "axios";
import { error } from "jquery";
import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";

// const data=function(){
//     return{
//          status=follows,
//     }
// }
function FollowButton(props) {
    const { user_id, follows } = props;
    const [data, setData] = useState({ status: follows });
    // console.log([user_id]);
    console.log({ follows, data });
    useEffect(() => {
        const temp = follows === "0" || !follows ? false : true;
        setData({ ...data, status: temp });
        console.log("temp " + temp);
    }, [follows]);
    const followUser = (user_id) => {
        return axios
            .post(`/follow/${user_id}`)
            .then(($response) => {
                const temp = $response.data.attached.length > 0 ? true : false;
                setData({ ...data, status: temp });
                console.log("Rsponse a raha ha ", $response.data);
            })
            .catch((error) => {
                if (error.response.status == 401) {
                    window.location = "/login";
                }
            });
    };

    return (
        <button
            className="btn btn-primary ml-4"
            onClick={() => followUser(user_id)}
        >
            {data.status ? "UnFollow" : "Follow"}
        </button>
    );
}

export default FollowButton;

if (document.getElementById("followButton")) {
    let user_id = document
        .getElementById("followButton")
        .getAttribute("user_id");
    let follows = document
        .getElementById("followButton")
        .getAttribute("follows");
    ReactDOM.render(
        <FollowButton user_id={user_id} follows={follows} />,
        document.getElementById("followButton")
    );
}
