const isEmailValid=(e)=>{
    console.log(e.target.value);
  }
  const isPassMatched=(e)=>{
    const pass=document.getElementById("pass").value;
    const confirmPass=e.target.value;
    if(pass!==confirmPass){
      document.getElementById("notifyMatchPass").innerText="Password does not match";
    }
  }
  const checkPass=(e)=>{
    const pass=e.target.value;
    const confirmPass=document.getElementById("confirmPass").value;

    const notifier=document.getElementById("notifyMatchPass").innerText;
    if(notifier!==""){
      if(pass==confirmPass){
        document.getElementById("notifyMatchPass").innerText="";
      } 
    }
    
  }

  // const addAddress=()=>{
  //   let noOfAddress=document.getElementById("addresses").value;
  //   noOfAddress++;
  //   document.getElementById("addresses").value=noOfAddress;
  //   console.log(noOfAddress);

  //   const mainSection=document.getElementById("allAddresses");

  //   let div1=document.createElement('div');
  //   div1.id=`address${noOfAddress}`;
  //   div1.className="mb-5 row align-items-center";

  //   let label1 = document.createElement("label");
  //   label1.className ="form-label-title col-lg-2 col-md-3 mb-0";
  //   label1.innerText = "Address";

  //   div1.appendChild(label1);

  //   let div2=document.createElement('div');
  //   div2.className="col-md-9 col-lg-9";

  //   let div3=document.createElement('div');
  //   div3.className="mb-3";

  //   let label2= document.createElement("label");
  //   label2.innerText = "";

  //   var inputElement = document.createElement('input');
  //   inputElement.className="form-control"
  //   inputElement.setAttribute('type', 'text');
  //   inputElement.setAttribute('name', `addr${noOfAddress}_main`);
  //   inputElement.setAttribute('placeholder', 'Enter Address');

  //   div3.appendChild(label2);
  //   div3.appendChild(inputElement);


  //   let div4=document.createElement('div');
  //   div4.className="row";


  //   let i=0;
  //   for(i=0;i<4;i++){
  //     let labelText=i===0?"City":i===1?"State":i==2?"Country":"Zip Code";
  //     let inputName=i===0?`addr${noOfAddress}_city`:i===1?`addr${noOfAddress}_state`:i==2?`addr${noOfAddress}_country`:`addr${noOfAddress}_zip`;

  //     console.log(labelText,inputName);

  //     let div=document.createElement('div');
  //     div.className="col-md-6 col-lg-6 mb-2";

  //     let label= document.createElement("label");
  //     label.innerText = labelText;

  //     var inputElement = document.createElement('input');
  //     inputElement.className="form-control"
  //     inputElement.setAttribute('type', 'text');
  //     inputElement.setAttribute('name', inputName);

  //     div.appendChild(label);
  //     div.appendChild(inputElement);

  //     div4.appendChild(div);

  //   }

  //   div2.appendChild(div3);
  //   div2.appendChild(div4);

  //   div1.appendChild(div2);


  //   let crossBtn=document.createElement('div');
  //   crossBtn.className="col-sm-1";

  //   let crossIcon=document.createElement("i");
  //   crossIcon.className = "ri-close-fill text-danger cancelIcon";
  //   crossIcon.style.cursor="pointer";
  //   crossIcon.style.fontWeight="bolder";
  //   crossIcon.onclick = function() {
  //     deleteAddress(this.parentElement);
  //     };
      
  //   crossBtn.appendChild(crossIcon);

  //   div1.appendChild(crossBtn);

  //   mainSection.appendChild(div1);
    
    
  // }


  // const deleteAddress=(e)=>{
  //   $(e).parent().remove();  
  // }