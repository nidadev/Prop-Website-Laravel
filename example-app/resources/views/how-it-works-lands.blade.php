@extends('layouts.app')

@section('main')
<section id="center" class="center_reg">
    <div class="center_om bg_backo">
        <div class="container-xl">
            <div class="row center_o1 m-auto text-center">
                <div class="col-md-12">
                    <h2 class="text-white">How it Works Lands</h2>
                    <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Register </h6>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="login" class="p_3">
    <div class="container-xl">
        <div class="row login_1">
            <div class="col-md-12">
               <p>
               <h4>How Propelyze Transforms Your Workflow<h4>
<h4>A Modern Approach to Streamlined Property Data Management</h4>
Propelyze is transforming how property data is managed by removing the hassle of labor-intensive manual tasks. Our cutting-edge platform lets you quickly oversee property information and initiate marketing campaigns in just a few minutes. This enables you to concentrate on strategic planning rather than being bogged down by monotonous data management. Our advanced techniques simplify gathering and validating data, guaranteeing that you obtain precise and trustworthy information. Check out the sections on the right to discover how Propelyze can boost your productivity and revolutionize your workflow with our innovative technology.
<h4>Advanced Data Integration</h4>
Propelyze pulls data from many trusted sources, including Zillow, Lands of America, Realtor.com, Redfin, LandFlip, and many other local property databases. We ensure comprehensive market insights and precise property valuations by consolidating information from these diverse platforms. Our integration allows for accurate and immediate search results, helping you make informed decisions quickly.
<h4>Dynamic Pricing Options</h4>
We offer a range of pricing models tailored to your needs. Choose from our regional, municipal, or specialized geo-based pricing plans. Each model starts with calculating your selected area's average market value per acre and allows for flexible adjustments based on local market conditions. This ensures you receive 
We account for variations in pricing across different regions and acreage sizes, allowing you to fine-tune the offer price per acre according to your preferences.
<h4>Location Insights and Ranking</h4>
Our advanced tool swiftly pinpoints counties and acreage ranges that perfectly match your search criteria. With seamless DataTree integration, we provide precise parcel counts for each location, giving you a clear understanding of how many parcels are available for download in your selected areas. This helps you focus your efforts on the most relevant locations.
<h4>Seamless Data Extraction</h4>
Propelyze, as a licensed DataTree partner, simplifies property data retrieval by directly handling the extraction process. You receive detailed reports featuring extensive property data, including valuation and geographic information. Our platform delivers all the essential information needed for informed decision-making, covering various land types and property attributes.
<h5>Search Criteria</h5>
<h4>Hover To View More</h4>
To find out more about our search options, all you have to do is hover your cursor over any of the input fields on the left.
<h4>Saved search</h4>
This tool lets you save as many different search setups as you need for all your unique strategies.
<h4>Polygon Search</h4>
Activate the lasso/polygon tool by choosing it from the toolbar. This functionality lets you define specific property searches within a designated area. Please note that this feature's availability may differ based on your subscription tier.
<h4>Get Count </h4>
Instantly check the number of owners that match your search parameters.
<h4>Search Bar</h4>
Start by inputting a state, county, city, or zip code in the search field. With this basic information, you can conduct a general search or fine-tune your results by applying advanced filters for more specificity.
<h4>Multiple Area Search</h4>
This feature allows you to conduct searches in multiple locations simultaneously. Simply enter a location in the search box and utilize this tool to add it to your selected areas.
<h4>Search </h4>
Click the search button to view your results instantly. This allows you to quickly access the data you need.
<h4>Advanced Search</h4>
Expand or collapse advanced search fields by clicking the option. This lets you adjust your search parameters easily.
<h4>Secondary Acreage Increment</h4>
Increase the size of acreage intervals to enhance your search. This allows for a broader selection of results.
<h4>Minimum Acreage</h4>
Please indicate the smallest land size you would like us to consider during your search. 
<h4>Maximum Acreage </h4>
Let us know the largest size of land you wish to have included in your search criteria.
<h4>Acreage Increment</h4>
This option enables you to see land categorized by specific size ranges. For example, if you choose a 10-acre increment, the results will be organized into categories like 0 to 10 acres, 10 to 20 acres, etc. Conversely, if you opt for an increment of 3, the results will be displayed in ranges such as 0 to 3 acres and 3 to 6 acres. Additionally, we will include an estimated price or offer for each acre within these size categories.
<h4>Lowest Price per Acre</h4>
Specify the lowest price per acre you expect in the outcomes. This figure is determined by the average prices in the county.
<h4>Highest Price per Acre</h4>
Indicate the highest price per acre you would like to see. This amount represents the standard pricing within the county.
<h4>Discount Percentage</h4>
Determine the percentage discount you wish to apply to the market rate for each acre. This can be modified on the results page and will affect the final purchase price criteria utilized in your search.
<h4>Minimum Budget</h4>
Identify the least amount you are ready to allocate to acquire a property.
<h4>Maximum Budget</h4>
Specify the maximum amount you are willing to invest in buying a property.
<h4>Pricing Options</h4>
Decide on your preferred method for evaluating property values. You can opt for a range of comparisons, focus solely on active listings, or examine sold properties. Additionally, you can tailor the criteria to narrow down the comparisons used in your pricing evaluation.
<h4>Hover To View More</h4>
For more information about our search options, place your cursor over any input fields on the left!
<h4>Select Land Uses/Property Types</h4>
Select the categories of land or properties for your search by marking or unmarking the boxes adjacent to each option, making it easy to customize your search criteria.
<h4>Additional Land Uses</h4>
Explore a wider variety of land use possibilities, encompassing different types of residential options, and determine if you want to include all categories of land use in your search.
<h4>In State Owner</h4>
Decide if you want to include property owners whose mailing address is within the same state as the property, useful for targeting local owners.
<h4>In County Owner</h4>
Decide whether to incorporate or omit owners depending on whether their mailing address is in the same county as the property, helpful for more localized searches.
<h4>Owner Occupied</h4>
Sort according to whether the owner's mailing address aligns with the property's address, ideal for identifying owner-occupied properties.
<h4>Corporate-Owned Properties</h4>
Incorporate or omit assets that are held by companies.
<h4>Do Not Mail</h4>
Exclude property owners who have opted out of receiving mail, ensuring your marketing efforts respect their preferences.
</h4>Number Properties Owned</h4>

Look up information according to the number of properties owned by an individual, which can be useful for identifying major property owners.
<h4>Owner Name</h4>
Locate property owners using their individual names, making it easy to find specific owners.
<h4>Mailing State</h4>
Focus your search on property owners within a specific state, allowing you to target particular regions effectively.
<h4>Mailing Zip Code</h4>
Refine your search to include only owners in a specific zip code, ideal for pinpointing precise geographic areas.
Assessed Improvement Percentage %
Discover properties by evaluating the percentage of upgrades, including structures or buildings. The county assessor's office calculates this improvement percentage, allowing you to sort properties according to the enhancements.
Assessed Value ($)
Search for properties within a specified range of assessed land value. The county assessor sets this value, which helps you identify properties based on their land worth.
Assessed Land Value
Search for properties based on the evaluated worth of enhancements such as buildings, wells, or other improvements. The county assessor determines this valuation, which aids in identifying properties that have undergone substantial upgrades.
Market Improvement Value
Sort properties according to the assessed market value of any upgrades. This encompasses improvements like structures or wells, with values determined by the county assessor's office.
Market Land Value
Look for properties that fall within a specific range of land value in the market. The county assessor's information enables you to identify properties according to their present market value.
Tax Status
Locate properties whose owners are either up-to-date or behind on their tax payments. This criterion allows you to focus on properties with particular tax payment conditions.
Cities
Search for real estate in a particular city to focus your search on urban locations that interest you.
Zip Code
Look for real estate in a designated zip code. This allows you to concentrate on specific areas or postal districts.
Subdivision
Find real estate options in a specific neighborhood. This filter lets you focus on some residential regions or planned housing projects.
Census Tract
Look for properties located within a specified census tract. It enables you to concentrate on particular demographic or regional zones.
Zoning
Search for properties according to their zoning designations, like residential or agricultural categories (for instance, A1 or R1). This ensures that the properties align with your zoning criteria.
Living Area Size
Look for properties by their square footage of living space. If you want entirely unoccupied land, adjust both the minimum and maximum values to zero.
Homeowners Association (HOA)
Narrow down your property search by their HOA membership status. This allows you to locate homes affiliated with an HOA or those that aren’t.
Unassigned Address
Look for properties that either possess an assigned address or lack one altogether. This can be helpful in identifying properties with particular addressing concerns.
APN Range
Locate properties based on a designated range of Assessor's Parcel Numbers (APN). This functionality enables searches using specific APN ranges or blocks for accurate targeting.
Flood Zone Codes
Filter properties by specific flood zone codes to assess flood risk and zoning requirements.
Last Sale Date 
Search properties by the most recent sale date, with options to filter by date range or a specific timeframe.
Last Sale Price
Find properties by their last sale price to focus on those within your preferred price history.
Deed Type
Locate properties by the type of deed, offering insights into ownership and transaction details.
Listing Status
Filter by current listing status, like active or pending, to find properties still on the market.
Clear Search
Quickly clear all search criteria and return to the default settings for a fresh start.



               </p>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
    span,
    .incorrect {
        color: red;
    }

    p.result {
        color: green;
    }
</style>

</body>

</html>