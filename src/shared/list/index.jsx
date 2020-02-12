import React, { Component } from "react";
import PropTypes from "prop-types";
import "./styles.css";

const propTypes = {
  /** Array of elements to list */
  children: PropTypes.array,
  /** Component of each element */
  ListItem: PropTypes.any,
  /** Unique identifier for detect selected */
  identifier: PropTypes.string,
  /** Class of list item */
  className: PropTypes.string,
  /** Identifier value of selected item */
  selected: PropTypes.any,
  /** Function to trigger on item click (item object will be passed as param) */
  onItemClick: PropTypes.func,
  /** Aditional props to pass to each item */
  itemProps: PropTypes.object
};

class List extends Component {
  render() {
    const {
      children,
      ListItem,
      selected,
      identifier,
      className,
      onItemClick,
      itemProps
    } = this.props;
    return (
      <div>
        <ul className={`list ${className || ""}`}>
          {children.length
            ? children.map((item, index) => {
                const isSelected = item[identifier || "id"] === selected;
                if (ListItem) {
                  return (
                    <ListItem
                      key={item[identifier || "id"]}
                      {...item}
                      {...itemProps}
                      index={index}
                      className={`${isSelected ? "selected" : ""}`}
                      onClick={() => (onItemClick ? onItemClick(item) : null)}
                    />
                  );
                } else {
                  return (
                    <li
                      key={item[identifier || "id"]}
                      index={index}
                      {...itemProps}
                      className={`${isSelected ? "selected" : ""}`}
                      onClick={() => (onItemClick ? onItemClick(item) : null)}
                    >
                      {item}
                    </li>
                  );
                }
              })
            : null}
        </ul>
      </div>
    );
  }
}

List.propTypes = propTypes;

export default List;
