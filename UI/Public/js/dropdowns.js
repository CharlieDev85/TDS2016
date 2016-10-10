/**
 * Created by carle on 8/10/2016.
 */

var selectedState;
var selectedCounty;
var selectedSubcounty;
function reloadFromState(form)
{
    selectedState = form.state.options[form.state.options.selectedIndex].value;
    self.location = 'pcaforecast.php?state=' + selectedState + '&county=ALL&subcounty=ALL';
}
function reloadFromCounty(form){
    selectedState   = form.state.options[form.state.options.selectedIndex].value;
    selectedCounty  = form.county.options[form.county.options.selectedIndex].value;
    self.location   = 'pcaforecast.php?state=' + selectedState + '&county=' + selectedCounty + '&subcounty=ALL';
}
function reloadFromSubcounty(form){
    selectedState     = form.state.options[form.state.options.selectedIndex].value;
    selectedCounty    = form.county.options[form.county.options.selectedIndex].value;
    selectedSubcounty = form.subcounty.options[form.subcounty.options.selectedIndex].value;
    self.location = 'pcaforecast.php?state=' + selectedState + '&county=' + selectedCounty + '&subcounty=' + selectedSubcounty;
}