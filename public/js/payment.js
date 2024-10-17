const _0x76c158=_0x356e;function _0x255d(){const _0x2546ef=['11756wvFIdm','cherry-94f45.firebaseapp.com','AIzaSyBrvPsOIiRH6XKQuCclKiOKCCqLQhmNi1o','224328JgYOcO','5736204dbYjDk','13ElkNiW','272232LgXdOO','6775NESpMr','1894024SUNfhB','2qgwVlr','175622Kmimsm','429VwuQGp','161ChBDBR','390PYqDyZ','cherry-94f45','10IeqTdP'];_0x255d=function(){return _0x2546ef;};return _0x255d();}(function(_0x35c2f9,_0x1e3ff0){const _0xc1bf43=_0x356e,_0x49a059=_0x35c2f9();while(!![]){try{const _0x22650d=-parseInt(_0xc1bf43(0x10f))/0x1*(-parseInt(_0xc1bf43(0x110))/0x2)+parseInt(_0xc1bf43(0x111))/0x3*(parseInt(_0xc1bf43(0x116))/0x4)+parseInt(_0xc1bf43(0x10d))/0x5*(-parseInt(_0xc1bf43(0x113))/0x6)+-parseInt(_0xc1bf43(0x112))/0x7*(parseInt(_0xc1bf43(0x10c))/0x8)+parseInt(_0xc1bf43(0x10a))/0x9+-parseInt(_0xc1bf43(0x115))/0xa*(-parseInt(_0xc1bf43(0x10e))/0xb)+parseInt(_0xc1bf43(0x109))/0xc*(-parseInt(_0xc1bf43(0x10b))/0xd);if(_0x22650d===_0x1e3ff0)break;else _0x49a059['push'](_0x49a059['shift']());}catch(_0x35a99b){_0x49a059['push'](_0x49a059['shift']());}}}(_0x255d,0x7dfa3));function _0x356e(_0x319e03,_0x2d6960){const _0x255dff=_0x255d();return _0x356e=function(_0x356e3d,_0x2f4a42){_0x356e3d=_0x356e3d-0x109;let _0x5dfe32=_0x255dff[_0x356e3d];return _0x5dfe32;},_0x356e(_0x319e03,_0x2d6960);}const firebaseConfig={'apiKey':_0x76c158(0x118),'authDomain':_0x76c158(0x117),'projectId':_0x76c158(0x114),'storageBucket':'cherry-94f45.appspot.com','messagingSenderId':'519452342442','appId':'1:519452342442:web:d699e1c871a6fe9f8cb8d3','measurementId':'G-8ZY168LBJB'};

firebase.initializeApp(firebaseConfig);
var db = firebase.firestore();

export function handleFormSubmit(caCode, currentPlan) {
    // Convert caCode to uppercase
    const upperCaCode = caCode.toUpperCase();
    const generatedCode = gc(upperCaCode);
    console.log("Generated Code:", generatedCode); // Log the generated code

    if (currentPlan === 'standard') {
        let monthId = new Date().getMonth() + 1;
        let shortYearString = new Date().getFullYear().toString().slice(2, 4);
        
        // Create the document reference with uppercase caCode
        let docRef = db.collection('usrkey' + monthId + '_' + shortYearString).doc(upperCaCode);
        
        // Log the document reference path
        console.log("Saving to Collection:", 'usrkey' + monthId + '_' + shortYearString);
        console.log("Document ID:", upperCaCode);
        console.log("Document Reference Path:", docRef.path); // Log the full path

        docRef.set({
            code: generatedCode,
            exfeatures: false,
        }).then(() => {
            document.getElementById("res").innerHTML = "Std Generated Code: " + generatedCode;
            console.log("Document successfully updated for standard plan!");
            document.getElementById('statusMessage').innerText = 'Process completed. You may now log in.';
        }).catch((error) => {
            console.error("Error updating document: ", error);
            document.getElementById('statusMessage').innerText = 'Failed to update. Please try again.';
        });
    } else if (currentPlan === 'plus') {
        klangMode(upperCaCode); // Use uppercase caCode in klangMode as well
    }
}


// Modified gc function to return the generated code
function gc(caCode) {
    let id = caCode.toUpperCase();
    let x = parseInt(id.slice(-2)[0]);  
    let y = parseInt(id.slice(-1));

    let x1 = 2; 
    let x2 = 1;
    if(x > 4) {
         x1 = 1;
         x2 = 2;
    } 

    let y1 = 1; 
    let y2 = 2;
    if(y > 4) {
         y1 = 2;
         y2 = 1;
    } 

    let idx1 = x1;
    let idx2 = x1 + x2;
    let idx3 = idx2 + y1;
    let idx4 = idx3 + y2; 
    let idx5 = idx4 + idx2;
    let idx6 = idx5 + y1;
    let idx7 = idx6 + y2;

    
    if (!id) {
        // console.log('fail genvale');
        return null;
    }
    id = id.replace(/ca/gi, '');
    const month = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
    let d = new Date()
    let c_month = month[d.getMonth()]
    let rkey = parseInt(id);
    let sumsy = getTarikhShortYearSum();
    // alert((d.getMonth()+1))
    let mkey = (rkey * sumsy) % 26;
    // alert(mkey);
    let cacode = id.split('').map((val,idx,arr) => {
        switch (val) {
            case '0':
                return 'B';
                break;
            case '1':
                return 'D';
                break;
            case '2':
                return 'F';
                break;
            case '3':
                return 'H';
                break;
            case '4':
                return 'J';
                break;
            case '5':
                return 'L';
                break;
            case '6':
                return 'N';
                break;
            case '7':
                return 'P';
                break;
            case '8':
                return 'R';
                break;
            case '9':
                return 'T';
                break;
            default:
                return 'V';
                break;
            }
        }).join('');
         let verification_code = d.getFullYear();
        // previous code
        let res = 'C' + verification_code + revstr(cacode) + cacode + 'A';
        // res = res+verification_code
        res = vig(revstr(res), csr(c_month, mkey))
        res = res.toLowerCase();
        let indices = [idx1, idx2, idx3, idx4, idx5, idx6, idx7];

         for(let i = 0; i < indices.length; i++) {
        if(i % 2 === 0) {
             res = upper(res, indices[i]);
         } else {
        res = lower(res, indices[i]); 
        }
        }

    return res;
}



// klangMode function
function klangMode(ca_code) {
    let generatedCode = gc(ca_code); // Get the generated code

    let monthId = new Date().getMonth() + 1;
    let shortYearString = new Date().getFullYear().toString().slice(2, 4);
    let docRef = db.collection('usrkey' + monthId + '_' + shortYearString).doc(ca_code);

    docRef.set({
        code: generatedCode,
        klang: true,
    })
    .then(() => {
        document.getElementById("res").innerHTML = "Klang Generated Code: " + generatedCode;
        console.log("Document successfully updated with Klang mode!");
        document.getElementById('statusMessage').innerText = 'Process completed. You may now log in.';
    })
    .catch((error) => {
        console.error("Error updating document: ", error);
        document.getElementById('statusMessage').innerText = 'Failed to update. Please try again.';
    });
}

// Helper functions
function upper(text, index) {
    return text.slice(0, index) + text.slice(index).toUpperCase();
}

function lower(text, index) {
    return text.slice(0, index) + text.slice(index).toLowerCase();
}

function csr(msg, key) {
    let c = [];
    msg = msg.toUpperCase();
    key = parseInt(key);
    
    for (var i = 0; i < msg.length; i++) {
        let x = ((msg.charCodeAt(i) - 65) + key++) % 26;
        c.push(String.fromCharCode(x + 65));
    }
    
    return c.join('');
}

function vig(msg, key) {
    let c = [];
    msg = msg.toUpperCase();
    
    for (var i = 0; i < msg.length; i++) {
        let x = ((msg.charCodeAt(i) - 65) + (key.charCodeAt(i % key.length) - 65)) % 26;
        c.push(String.fromCharCode(x + 65));
    }
    
    return c.join('');
}

function revstr(text) {
    return text.split('').reverse().join('');
}

function getTarikhShortYearSum() {
    const shortYear = new Date().getFullYear().toString().slice(2, 4);
    let sum = 0;

    for (let i = 0; i < shortYear.length; i++) {
        sum += parseInt(shortYear[i]);
    }

    return sum;
}

