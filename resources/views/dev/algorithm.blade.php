

function mapSubCodeToColor(subcode){
    if(subcode == "SL"){
        return "blue";
    } else if(subcode == "TW"){
        return "yellow";
    } else if(subcode == "TR"){
        return "navy";
    } else if(subcode == "AU"){
        return "orange";
    } else if(subcode == "IN"){
        return "purple";
    } else if(subcode == "CA"){
        return "d-green";
    } else if(subcode == "KA"){
        return "red";
    } else if(subcode == "WA"){
        return "red";   
    } else if(subcode == "OA"){
        return "green";
    } else if(subcode == "SA"){
        return "grey";
    }
    return "blue";
}

/* Main function for processing the transport plans accepts a group of 
   patrons and returns an array of cars */
function runTransportAlgorithm(patrons, nearbySetsList){
    var driversThere = new Array();
    var driversBack = new Array();
    var passengersThere = new Array();
    var passengersBack = new Array();

    var carsThere = new Array();
    var carsBack = new Array();
    var walkingThere = new Array();
    var walkingBack = new Array();

    processSuburbMappings(patrons);

    console.log(patrons);

    for(var i = 0; i < patrons.length; i++){
        if(patrons[i].carthere == "driving"){
            driversThere.push(patrons[i]);
        } else {
            if(patrons[i].carthere != "none" && patrons[i].carthere != "staying"){
                passengersThere.push(patrons[i]); 
            }
            
        }
        if(patrons[i].carback == "driving"){
            driversBack.push(patrons[i]);
        } else {
            if(patrons[i].carback != "none" && patrons[i].carback != "staying"){
                passengersBack.push(patrons[i]);
            }
        }
    }

    /* Place the drivers in their cars. The cars are arrays with the driver in the 
    first position */ 
    for(var i = 0; i < driversThere.length; i++){
        carsThere.push(new Array(driversThere[i]));
    }
    for(var i = 0; i < driversBack.length; i++){
        carsBack.push(new Array(driversBack[i]));
    }

    /* Process preferences */
    /*for(var i = 0; i < passengersThere.length; i++){
        if(passengersThere[i].carthere == "none" || passengersThere[i].carthere == "staying"){
            passengersThere.splice(i, 1);
        }
    }

    for(var i = 0; i < passengersBack.length; i++){
        if(passengersBack[i].carback == "none" || passengersBack[i].carback == "staying"){
            passengersBack.splice(i, 1);
        }
    }*/

    for(var i = 0; i < passengersThere.length; i++){
        if(passengersThere[i].carthere != "none" && passengersThere[i].carthere != "driving" &&
            passengersThere[i].carthere != "staying"  && passengersThere[i].carthere != "any"){
            if(driverIDIndexInCarList(carsThere, passengersThere[i].carthere) != -1){
                if(carsThere[driverIDIndexInCarList(carsThere, passengersThere[i].carthere)].length < 5){
                    carsThere[driverIDIndexInCarList(carsThere, passengersThere[i].carthere)].push(passengersThere[i]);
                }
            }
        }
    }

    removeProcessedPassengers(passengersThere, carsThere);

    for(var i = 0; i < passengersBack.length; i++){
        if(passengersBack[i].carback != "none" && passengersBack[i].carback != "driving" &&
            passengersBack[i].carback != "staying"  && passengersBack[i].carback != "any"){
            if(driverIDIndexInCarList(carsBack, passengersBack[i].carback) != -1){
                if(carsBack[driverIDIndexInCarList(carsBack, passengersBack[i].carback)].length < 5){
                    carsBack[driverIDIndexInCarList(carsBack, passengersBack[i].carback)].push(passengersBack[i]);
                }
            }
        }
    }

    removeProcessedPassengers(passengersBack, carsBack);

    if(carsThere.length != 0){
        processPlan(patrons, carsThere, walkingThere, passengersThere, nearbySetsList, "there");
    }

    if(carsBack.length != 0){
        processPlan(patrons, carsBack, walkingBack, passengersBack, nearbySetsList, "back");
    }

    return new Array(carsThere, carsBack, walkingThere, walkingBack);
}



function processPlan(patronsList, carsList, walkingList, passengersList, nearbySetsList, direction){
    /* Remove the nearby sets that are not relevant to the current transport plan 
    this means that there are not at least two patrons of the nearby set that are attending the event. */
    var tempPassengersList = new Array();
    for(var i = 0; i < passengersList.length; i++){
        tempPassengersList.push(passengersList[i])
    }

    for(var i = 0; i < carsList.length; i++){
        for(var j = 0; j < carsList[i].length; j++){
            tempPassengersList.push(carsList[i][j]);
        }
    }

    var relevantNearbySets = 
        processNearbySetsFromPassengerList(nearbySetsList, tempPassengersList);

    /* Sort relevantNearbySets by length */
    //var b = list[y];
    //list[y] = list[x];
    //list[x] = b;
    for(var k = 0; k < 5; k++){
        for(var i = 0; i < relevantNearbySets.length; i++){
            if(!(i+1 >= relevantNearbySets.length)){
                if(relevantNearbySets[i].length < relevantNearbySets[i+1].length){
                    var tempNBSet = relevantNearbySets[i];
                    relevantNearbySets[i] = relevantNearbySets[i+1];
                    relevantNearbySets[i+1] = tempNBSet;
                }
            } 
        }
    }

    /* Process the nearby sets into their cars */

    /* Process nearby sets with three passengers */
    for(var i = 0; i < relevantNearbySets.length; i++){
        if(relevantNearbySets[i].length == 3){
            /* Find a car that has two people in it if the driver or the first passenger share the same suburb as the nearby set then add the nearby set to this car */
            var tempBestCarIndex = "false";
            for(var j = 0; j < carsList.length; j++){
                /*if(carsList[j].length == 1){
                    if(carsList[j][0].suburb == relevantNearbySets[i][0].suburb){
                        tempBestCarIndex = j;
                    } 
                }*/
                if(carsList[j].length == 2){
                    /* If the suburb of either the driver or the first passenger is the same as the nearby set of three */
                    if(carsList[j][1].suburb == relevantNearbySets[i][0].suburb || carsList[j][0].suburb == relevantNearbySets[i][0].suburb){
                        tempBestCarIndex = j;
                    }
                    /* If the suburb of both the driver or the first passenger is the same as the nearby set of three, then push immediately */
                    if(carsList[j][i].suburb == relevantNearbySets[i][0].suburb && carsList[j][0].suburb == relevantNearbySets[i][0].suburb){
                        tempBestCarIndex = j;
                        //addToPlan(carsList, walkingList, relevantNearbySets[i][j], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
                        break;
                    }
                }
            }

            /* If there is no car that has the driver or first passenger suburb the same as the suburb for the nearby set of three, then if there is no other
            passenger of the same suburb as the nearby set then add the nearby set to a car with only three spaces. Otherwise leave it how it is (tempBestCarIndex = false)
            and the nearby set of three will be placed in an empty car (a car with four spaces). */
            if(tempBestCarIndex == "false"){
                for(var k = 0; k < passengersList.length; k++){
                    if(passengersList[k].suburb == relevantNearbySets[i][0].suburb
                        && passengersList[k].patron_id != relevantNearbySets[i][0].patron_id
                        && passengersList[k].patron_id != relevantNearbySets[i][1].patron_id
                        && passengersList[k].patron_id != relevantNearbySets[i][2].patron_id){
                        tempBestCarIndex = "place in empty car";
                        
                    }
                }
            }

            if(tempBestCarIndex != "place in empty car"){
                for(var m = 0; m < carsList.length; m++){
                    if(carsList[m].length == 2){
                        tempBestCarIndex = m;
                        break;
                    }
                }
            }

            if(tempBestCarIndex == "place in empty car"){
                tempBestCarIndex = "false";
            }

            if(tempBestCarIndex != "false"){
                for(var k = 0; k < relevantNearbySets[i].length; k++){
                    addToPlan(carsList, walkingList, relevantNearbySets[i][k], tempBestCarIndex, direction);
                }
            }
        }
    }

    /* Process nearby set where one of the passengers of the nearby set were processed as a preference */
    for(var i = 0; i < relevantNearbySets.length; i++){
        for(var j = 0; j < relevantNearbySets[i].length; j++){    
            if(carIndexOfPassenger(carsList, walkingList, relevantNearbySets[i][j]) != -1){
                for(var k = 0; k < relevantNearbySets[i].length; k++){
                    addToPlan(carsList, walkingList, relevantNearbySets[i][k], carIndexOfPassenger(carsList, walkingList, relevantNearbySets[i][j]), direction);
                }
            }        
        }
    }

    /* Process the rest of the nearby sets by the closest driver to the nearby set */
    for(var i = 0; i < relevantNearbySets.length; i++){
        var bestDriver = calculateBestDriver(carsList, relevantNearbySets[i][0], relevantNearbySets[i].length);
        for(var j = 0; j < relevantNearbySets[i].length; j++){
            if(!isDriver(carsList, relevantNearbySets[i][j])){
                addToPlan(carsList, walkingList, relevantNearbySets[i][j], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
            }
        }   
    }

    removeProcessedPassengers(passengersList, carsList);

    /* Separate passengers into new arrays */
    suburbSeparatedPassengersList = new Array();
    for(var i = 0; i < passengersList.length; i++){
        var processed = false;
        for(var j = 0; j < suburbSeparatedPassengersList.length; j++){
            if(suburbSeparatedPassengersList.length > 0){
                if(suburbSeparatedPassengersList[j][0].suburb == passengersList[i].suburb){
                    suburbSeparatedPassengersList[j].push(passengersList[i]);
                    processed = true;
                }   
            } else {
                suburbSeparatedPassengersList.push(new Array(passengersList[i]));
            }
        }
        if(!processed){
            suburbSeparatedPassengersList.push(new Array(passengersList[i]));
        }
    }

    removeProcessedPassengers(passengersList, carsList);

    /*Process passengers who share a suburb with one of the suburbs that a driver is already intending to visit*/
    for(var i = 0; i < passengersList.length; i++){
        for(var j = 0; j < carsList.length; j++){
            for(var k = 0; k < carsList[j].length; k++){
                if(passengersList[i].suburb == carsList[j][k].suburb){
                    addToPlan(carsList, walkingList, passengersList[i], j, direction);
                }
            }
        }
    }

    /* Process passengers which share the same suburb as a driver */
    for(var i = 0; i < suburbSeparatedPassengersList.length; i++){
        for(var j = 0; j < suburbSeparatedPassengersList[i].length; j++){
            for(var k = 0; k < carsList.length; k++){
                var thisthing = suburbs[String(suburbSeparatedPassengersList[i][j].suburb).concat(carsList[k][0].suburb)];
                var sub1 = suburbSeparatedPassengersList[i][j].suburb;
                var sub2 = carsList[k][0].suburb;
                if(suburbs[String(suburbSeparatedPassengersList[i][j].suburb).concat(carsList[k][0].suburb)] == 1){
                    if(carsList[k].length < 5){
                        addToPlan(carsList, walkingList, suburbSeparatedPassengersList[i][j], k, direction);
                        break;
                    }
                }
            }   
        }
    }

    removeProcessedPassengers(passengersList, carsList);

    for(var currentDistantRank = 0; currentDistantRank < 12; currentDistantRank++){
        for(var i = 0; i < passengersList.length; i++){
            var bestDriver = calculateBestDriver(carsList, passengersList[i], 1);
            if(suburbs[String(bestDriver.suburb).concat(passengersList[i].suburb)] == currentDistantRank){
                
                var bestCarIndex = driverIDIndexInCarList(carsList, bestDriver.patron_id);

                /* If the car of bestdriver has length equal to four and carsList does not contain the patron's suburb in 
                any of the non-full cars, and there exists a near empty (length one or two including driver). Then add to
                the near empty car */
                if(carsList[bestCarIndex].length == 4){
                    /* cars list does not contain the patron's suburb in any of the non-empty cars */
                    var suburbContains = false;
                    for(var m = 0; m < carsList.length; m++){
                        if(carsList[m].length != 5){
                            for(var n = 0; n < carsList[m].length; n++){
                                if(carsList[m][n].suburb == passengersList[i].subrub){
                                    suburbContains = true;
                                }
                            }
                        }
                    }
                    
                    /* cars list contains a near empty car */
                    var nearEmptyExists = false;
                    var nearEmptyCarIndex = -1;
                    for(var m = 0; m < carsList.length; m++){
                        if(carsList[m].length == 1 || carsList[m].length == 2){
                            nearEmptyExists = true;
                            nearEmptyCarIndex = m;
                        }
                    }
                    if(!suburbContains && nearEmptyExists){
                        addToPlan(carsList, walkingList, passengersList[i], nearEmptyCarIndex, direction);
                    }
                }

                /* If the car of the bestDriver has a length of 4 and there exists more than one person with the current suburb, 
                and there exists a car that can fit persons sharing the suburb then add it to that car*/ 
                addToPlan(carsList, walkingList, passengersList[i], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);

                /*Process passengers who share a suburb with one of the suburbs that a driver is already intending to visit*/
                
                for(var m = 0; m < passengersList.length; m++){
                    for(var n = 0; n < carsList.length; n++){
                        for(var o = 0; o < carsList[n].length; o++){
                            if(passengersList[m].suburb == carsList[n][o].suburb){
                                addToPlan(carsList, walkingList, passengersList[m], n, direction);
                            }
                        }
                    }
                }

            }
        }
    }

    removeProcessedPassengers(passengersList, carsList);

    for(var i = 0; i < passengersList.length; i++){
        var bestDriver = calculateBestDriver(carsList, passengersList[i], 1);
        addToPlan(carsList, walkingList, passengersList[i], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
    }

    removeProcessedPassengers(passengersList, carsList);
}

function visitingSuburbs(car){
    var suburbVisits = new Array();
    for(var i = 0; i < car.length; i++){
        suburbVisits.push(car[i].suburb);
    }
    return suburbVisits;
}

/* Takes a set of cars and a passenger, returns the best driver for the 
passenger. If the most efficient driver has a full car, then the next most efficient 
driver that does not have a full car is the best driver. */
function calculateBestDriver(cars, patron, numPatrons){
    var i = 0;
    var bestDriver = cars[i][0];
    var currentSuburbPairRank = suburbs[String(patron.suburb).concat(cars[i][0].suburb)];
    var bestCarIndex = 0;
    var carSummations = new Array();
    var currentAvgDistance = 99999999;
    while(cars[i].length > 4 - (numPatrons - 1)){
        i++;
        if(i >= cars.length){
            return -1;
        }
        bestDriver = cars[i][0];
        bestCarIndex = i;
        currentSuburbPairRank = suburbs[String(patron.suburb).concat(cars[i][0].suburb)];
        currentAvgDistance = avgDistance(cars[i], patron);
    }
    /*for(; i < cars.length; i++){
        if(suburbs[String(patron.suburb).concat(cars[i][0].suburb)] < currentSuburbPairRank
            && cars[i].length < 5 - (numPatrons - 1)){
            currentSuburbPairRank = suburbs[String(patron.suburb).concat(cars[i][0].suburb)];
            bestDriver = cars[i][0];
            bestCarIndex = i;
        }
    }*/
    for(; i < cars.length; i++){
        if(avgDistance(cars[i], patron) < currentAvgDistance
            && cars[i].length < 5 - (numPatrons - 1)){
            bestDriver = cars[i][0];
            currentAvgDistance = avgDistance(cars[i], patron);
            bestCarIndex = i;
        }
    }

    

    /* Make the best driver the driver with the least passengers but with the same suburb as the current best driver */
    if(bestDriver.suburb != patron.suburb && numPatrons > 1){
        for(var i = 0; i < cars.length; i++){
            if(cars[bestCarIndex].length > cars[i].length &&
                cars[bestCarIndex].suburb == cars[i].suburb){
                bestDriver = cars[i][0];
                bestCarIndex = i;
            }
        }
    }
    return bestDriver;
}

function avgDistance(car, patron){
    var tempSum = 0;
    for(var i = 0; i < car.length; i++){
        tempSum = tempSum + suburbs[String(patron.suburb).concat(car[i].suburb)];
    }
    return tempSum/(car.length);
}

function isDriver(cars, patron){
    for(var i = 0; i < cars.length; i++){
        if(cars[i][0].patron_id == patron.patron_id){
            return true;
        }
    }
    return false;
}

function seatsRemaining(cars){
    var sumOfSeats = 0;
    for(var i = 0; i < cars.length; i++){
        sumOfSeats = sumOfSeats + cars[i].length;
    }
    if(sumOfSeats >= (cars.length * 5)){
        return false;
    }
    return true;
}

function numOfSeatsRemaining(cars){
    var sumOfSeats = 0;
    for(var i = 0; i < cars.length; i++){
        sumOfSeats = sumOfSeats + cars[i].length;
    }
    return (cars.length * 5) - sumOfSeats;
}

function addToPlan(cars, walking, passenger, carIndex, direction){
    if(seatsRemaining(cars)){
        if(carIndex != -1 && cars[carIndex].length != 5){
            if(!planContains(cars, walking, passenger)){
                if((direction == "there" && passenger.carthere != "none")
                    || (direction == "back" && passenger.carback != "none")){
                    cars[carIndex].push(passenger); 
                }
            }
            return false;
        }
    } else {
        if(!planContains(cars, walking, passenger)){
            if((direction == "there" && passenger.carthere != "none")
                || (direction == "back" && passenger.carback != "none")){
                walking.push(passenger);
            }
        }
        return false;
        //walking.push(passenger);
    }
}

function planContains(cars, walking, passenger){
    for(var i = 0; i < cars.length; i++){
        for(var j = 0; j < cars[i].length; j++){
            if(cars[i][j].patron_id == passenger.patron_id){
                return true;
            }
        }
    }
    for(var i = 0; i < walking.length; i++){
        if(walking[i].patron_id == passenger.patron_id){
            return true;
        }
    }
    return false;
}

function carIndexOfPassenger(cars, walking, passenger){
    for(var i = 0; i < cars.length; i++){
        for(var j = 0; j < cars[i].length; j++){
            if(cars[i][j].patron_id == passenger.patron_id){
                return i;
            }
        }
    }
    for(var i = 0; i < walking.length; i++){
        if(walking[i].patron_id == passenger.patron_id){
            return -1;
        }
    }
    return -1;
}

function removeProcessedPassengers(passengersList, carsList){
    for(var i = 0; i < carsList.length; i++){
        for(var j = 0; j < carsList[i].length; j++){
            for(var k = 0; k < passengersList.length; k++){
                if(carsList[i][j].patron_id == passengersList[k].patron_id){
                    passengersList.splice(k, 1);
                }
            }
        }
    }
}

function processNearbySetsFromPassengerList(nearbySetsList, passengersList){
    relevantNearbySetsList = new Array();
    for(var i = 0; i < nearbySetsList.length; i++){
        var tempNearbySet = new Array();
        for(var j = 0; j < nearbySetsList[i].length; j++){
            for(var k = 0; k < passengersList.length; k++){
                if(nearbySetsList[i][j] == passengersList[k].patron_id){
                    tempNearbySet.push(nearbySetsList[i][j]);
                }
            }   
        }
        if(tempNearbySet.length > 1){
            relevantNearbySetsList.push(tempNearbySet);
        }
    }

    transformedNearbySetsList = new Array();
    for(var i = 0; i < relevantNearbySetsList.length; i++){
        var tempNearbySet = new Array();
        for(var j = 0; j < relevantNearbySetsList[i].length; j++){
            tempNearbySet.push(
                matchPatronIDToPatronFromList(passengersList, relevantNearbySetsList[i][j]));
        }
        transformedNearbySetsList.push(tempNearbySet);
    }
    return transformedNearbySetsList;
}

/*Give a list of patrons and a patron ID then return the patron which from
the patron list which matches the patron ID.*/
function matchPatronIDToPatronFromList(patronList, patronId){
    for(var i = 0; i < patronList.length; i++){
        if(patronList[i].patron_id == patronId){
            return patronList[i];
        }
    }

}

function getPatronIndexFromPatronList(patronsList, patronId){
    contains = false;
    for(var k = 0; k < patronsList.length; k++){
        if(patronsList[k].patron_id == patronId){
            return k;
        }
    }
    return -1;
}

function patronsListContainsPatronID(patronsList, patronId){
    contains = false;
    for(var k = 0; k < patronsList.length; k++){
        if(patronsList[k].patron_id == patronId){
            contains = true;
        }
    }
    return contains;
}

/* returns the index of a driver from a list of cars */
function driverIDIndexInCarList(cars, driverId){
    for(var i = 0; i < cars.length; i++){
        if(cars[i][0].patron_id == driverId){
            return i;
        }
    }
    return -1;
}



/* takes a patron and modifies the suburb field so that is useable by
the algorithm */
function processSuburbMappings(patrons){
    for(var i = 0; i < patrons.length; i++){
        if(patrons[i].suburb == "stlucia"){
            patrons[i].suburb = "SL";
        } else if(patrons[i].suburb == "toowong"){
            patrons[i].suburb = "TW";
        } else if(patrons[i].suburb == "taringa"){
            patrons[i].suburb = "TR";
        } else if(patrons[i].suburb == "auchenflower"){
            patrons[i].suburb = "AU";
        } else if(patrons[i].suburb == "indooroopilly"){
            patrons[i].suburb = "IN";
        } else if(patrons[i].suburb == "chapelhill"){
            patrons[i].suburb = "CA";
        } else if(patrons[i].suburb == "kelvingrove"){
            patrons[i].suburb = "KA";
        } else if(patrons[i].suburb == "woolongabba" || patrons[i].suburb == "duttonpark"
            || patrons[i].suburb == "fairfield" || patrons[i].suburb == "annerley"){
            patrons[i].suburb = "WA";
        } else if(patrons[i].suburb == "oxley" || patrons[i].suburb == "sherwood"
            || patrons[i].suburb == "corinda"){
            patrons[i].suburb = "OA";
        } else if(patrons[i].suburb == "sunnybank" || patrons[i].suburb == "willawong"
            || patrons[i].suburb == "logan"){
            patrons[i].suburb = "SA";
        }
    }