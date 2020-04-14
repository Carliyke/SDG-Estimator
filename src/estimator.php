<?php

/** This function uses the same values for the impact cases
 *  to update the values of severeImpact cases (i.e values of the impact cases * 5)
 */  
function multiplyByFive($value)
{
  $value = ($value * 5);
  return $value;
}

function covid19ImpactEstimator($data)
{

  $dataString = json_encode($data);

  $data = json_decode($dataString);

  $impact = array();

  $severeImpact = array();

  // Estimated number of currently infected.
  $currentlyInfected = ($data['reportedCases'] * 10);


  $infectionsByRequestedTime = ($currentlyInfected * 512);


  // Estimated number of severe positive cases. 
  $severeCasesByRequestedTime = ($infectionsByRequestedTime * 0.15);


  $totalHospitalBeds = $input['totalHospitalBeds'];


  /* Estimated number of available hospital beds for available cases 
  * (Note: The below computation is for hospitals with 95% hospital bed capacity).
  */
  $hospitalBedsByRequestedTime = ( ( $totalHospitalBeds * (0.35 * 0.95) ) - $severeCasesByRequestedTime );


  // Estimated number of severe positive cases that will require ICU care.
  $casesForICUByRequestedTime = ($infectionsByRequestedTime * 0.05);


  // Estimated number of severe positive cases that will require ventilators.
  $casesForVentilatorsByRequestedTime = ($infectionsByRequestedTime * 0.02);

  $avgDailyIncomeInUSD = $data['region']['avgDailyIncomeInUSD'];

  // Estimated amount of money the economy is likely to lose daily.
  $dollarsInFlight = round(($infectionsByRequestedTime * $avgDailyIncomeInUSD) / 30);

  // Pushing the required output values to the impact and severeImpact arrays
  array_push($impact, $currentlyInfected, $severeCasesByRequestedTime, $hospitalBedsByRequestedTime, $casesForICUByRequestedTime, $casesForVentilatorsByRequestedTime, $dollarsInFlight); 

  array_push($severeImpact, $currentlyInfected, $severeCasesByRequestedTime, $hospitalBedsByRequestedTime, $casesForICUByRequestedTime, $casesForVentilatorsByRequestedTime, $dollarsInFlight);

  $severeImpact = array_map("multiplyByFive", $severeImpact);

  $data['data'] = $data;
  $data['impact'] = $impact;
  $data['severeImpact'] = $severeImpact;

  $data = json_encode($data);

  return $data;
}