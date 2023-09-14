const handleAddValue=()=>{
    const attributeValue=document.getElementById("attribute_input").value;

    if(attributeValue!==""){
      const attributeSection=document.getElementById("attribute-value-sec");
      const prevAttr=localStorage.getItem('attributeValues');

      const spanElement=document.createElement("SPAN");
      spanElement.innerText=attributeValue;
      spanElement.classList.add('p-1', 'm-1', 'bg-primary', 'rounded');
      let i = document.createElement("i");
      i.className = "ri-close-circle-line attrRemoveIcon";
      i.onclick = function() {
        handleRemoveValue(spanElement.innerText);
      };
      spanElement.appendChild(i);
      attributeSection.appendChild(spanElement);
      
      

      let newValue="";
      if (prevAttr !== null) {
          newValue=localStorage.getItem('attributeValues')+", "+attributeValue;
          localStorage.setItem("attributeValues",newValue);
      } else {
        newValue=attributeValue;
        localStorage.setItem("attributeValues",newValue);
      }
      document.getElementById("allAttributes").value=newValue;
      document.getElementById("attribute_input").value = "";
    }
    else{
      alert("empty attribute input");
    }

    
  }
  const handleRemoveValue=(removalValue)=>{
    const attributeSection=document.getElementById("attribute-value-sec");
    const allChildrens = attributeSection.childNodes;
    
    
      let index=-1;
      // iterate over all child nodes
      allChildrens.forEach(child => {
        if(child.innerText==removalValue){
          index=Array.prototype.indexOf.call(attributeSection.children, child);
        }
        
      });
      if(index==-1){
        alert("value not matched");
      }
      else{

        attributeSection.removeChild(attributeSection.children[index]);
        let storageValues=localStorage.getItem('attributeValues').split(", ");
        if(storageValues!==null){
          const newValues=storageValues.filter(value=>value!=removalValue);
          let valueAsString="",v=0;

          if(newValues.length){
            for(v=0;v<newValues.length-1;v++){
              valueAsString=valueAsString+newValues[v]+", ";
            }
            valueAsString=valueAsString+newValues[v];
          }
          
          localStorage.setItem("attributeValues",valueAsString);
          document.getElementById("allAttributes").value=valueAsString;
        }
        else{
          alert("no attribute values exist");
        }
        
      }
  }

  const clearStorage=()=>{
    localStorage.removeItem("attributeValues");
  }