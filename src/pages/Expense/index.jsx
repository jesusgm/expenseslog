import React, { useEffect, useState } from "react";
import axios from "axios";
import Page from "../../shared/page/";
import { API_BASE_PATH } from "../../config";
import { useRouteMatch } from "react-router-dom";

function Expense() {
  const [expense, setExpense] = useState(null);

  let match = useRouteMatch();
  const hasExpense = expense !== null;

  useEffect(() => {
    axios
      .get(`${API_BASE_PATH}gastos/${match.params.id}`)
      .then(res => setExpense(res.data[0]));
  }, [hasExpense, match.params.id]);

  return (
    <Page title="Expense" match={match}>
      {expense ? <div>Description: {expense.description}</div> : null}
    </Page>
  );
}

export default Expense;
