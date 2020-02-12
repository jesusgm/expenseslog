import React from "react";
import Header from "../header/";

function Page({ children, match }) {
  return (
    <div className="page">
      <Header title={"Home"} path={match.path} />
      {children}
    </div>
  );
}

export default Page;
