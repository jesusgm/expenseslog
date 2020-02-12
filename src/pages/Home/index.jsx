import React, { useEffect, useState } from "react";
import axios from "axios";
import Page from "../../shared/page/";
import { API_BASE_PATH } from "../../config";
import { useRouteMatch } from "react-router-dom";
import List from "../../shared/list/";
import ExpenseItemList from "./components/expenseItemList/";

function Home() {
  const [expenses, setExpenses] = useState([]);

  useEffect(() => {
    axios.get(`${API_BASE_PATH}gastos`).then(res => {
      const exps = res.data;
      axios.get(`${API_BASE_PATH}categories`).then(res => {
        const cats = res.data;
        setExpenses(
          exps.map(expense => ({
            ...expense,
            category: cats.find(c => c.id === expense.category_id)
          }))
        );
      });
    });
  }, [expenses.length]);

  let match = useRouteMatch();

  return (
    <Page title="Home" match={match}>
      {expenses.length > 0 ? (
        <List ListItem={ExpenseItemList}>{expenses}</List>
      ) : null}
    </Page>
  );
}

export default Home;
