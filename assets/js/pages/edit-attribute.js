const handleAddValue = () => {
    const attributeValue = document.getElementById("attribute_input").value;

    if (attributeValue !== "") {
      const attributeSection = document.getElementById("attribute-value-sec");
      const spanElement = document.createElement("SPAN");
      spanElement.innerText = attributeValue;
      spanElement.classList.add('p-1', 'm-1', 'bg-primary', 'rounded');
      let i = document.createElement("i");
      i.className = "ri-close-circle-line attrRemoveIcon";
      i.onclick = function () {
        handleRemoveValue(spanElement.innerText);
      };
      spanElement.appendChild(i);
      attributeSection.appendChild(spanElement);

      let newValue = "";
      let storageVal = localStorage.getItem('attributeValues');
      if (storageVal !== null && storageVal != "") {
        newValue = localStorage.getItem('attributeValues') + ", " + attributeValue;
        localStorage.setItem("attributeValues", newValue);
      } else {
        newValue = attributeValue;
        localStorage.setItem("attributeValues", newValue);
      }
      document.getElementById("allAttributes").value = newValue;
    }
    else {
      alert("empty attribute input");
    }
  }
  const handleRemoveValue = (removalValue) => {
    console.log(removalValue, `${removalValue}`);
    const attributeValue = removalValue;
    const attributeSection = document.getElementById("attribute-value-sec");
    const allChildrens = attributeSection.childNodes;

    if (attributeValue != "") {
      let index = -1;
      console.log(attributeValue);
      // iterate over all child nodes
      allChildrens.forEach(child => {

        if (child.innerText == attributeValue) {
          index = Array.prototype.indexOf.call(attributeSection.children, child);
        }

      });
      if (index == -1) {
        alert("value not matched");
      }
      else {
        attributeSection.removeChild(attributeSection.children[index]);
        let storageValues = localStorage.getItem('attributeValues').split(", ");
        if (storageValues !== null) {
          const newValues = storageValues.filter(value => value != attributeValue);
          let valueAsString = "", v = 0;
          if (newValues.length) {
            for (v = 0; v < newValues.length - 1; v++) {
              valueAsString = valueAsString + newValues[v] + ", ";
            }
            valueAsString = valueAsString + newValues[v];
          }
          console.log(valueAsString, newValues);
          localStorage.setItem("attributeValues", valueAsString);
          document.getElementById("allAttributes").value = valueAsString;
        }
        else {
          alert("no attribute values exist");
        }

      }
    }
    else {
      alert("empty input");
    }
  }

  const clickSubmitAttribute = () => {
    localStorage.removeItem("attributeValues");
  }
