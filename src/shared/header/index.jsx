import React from "react";
import { Link } from "react-router-dom";
import Icon from "../icon/";

function Header({ title, path }) {
  return (
    <header className="App-header">
      {path !== "/" ? (
        <Link to="/">
          <Icon name="angle-left" />
        </Link>
      ) : null}
      {title}
    </header>
  );
}

export default Header;
