import React from "react";
import "./fontawesome-free-5.12.1-web/css/all.css";

function Icon({ name, size, spin, brand }) {
  const prefix = brand ? "fab" : "fa";

  return (
    <span
      className={`icon ${prefix} fa-${name} ${spin ? "spin" : ""} ${size ||
        ""}`}
    ></span>
  );
}

export default Icon;
