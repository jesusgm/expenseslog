import React from "react";
import { Link } from "react-router-dom";
import Icon from "../../../../shared/icon/";
import "./styles.css";

function ExpenseItemList({ id, description, user_id, category, amount, date }) {
  return (
    <li className="expense-item-list">
      <Link to={`/expenses/${id}`}>
        <Icon name={category.icon} />
        <span></span>
        <span>{id}</span>
        <span>{description}</span>
        <span>{amount}€ </span>
        {/* <span>{date}</span> */}
      </Link>
    </li>
  );
}

export default ExpenseItemList;
