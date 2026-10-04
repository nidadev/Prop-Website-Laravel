@extends('layouts.app2')

@section('content')
<section id="center" class="center_reg">
<div class="center_om bg_backo">
<div class="container-xl">
<div class="row center_o1 m-auto text-center">
<div class="col-md-12">
<h2 class="text-white">How Propelyze Works for Land</h2>
<h6 class="text-white mb-0 mt-3"><a class="text-white" href="{{ url('/home') }}">Home</a> <span class="mx-2 text-warning">/</span> Lands </h6>
</div>
</div>
</div>
</div>
</section>
<section id="login" class="p_3 guide-copy">
<div class="container-xl">
<div class="row login_1">
<div class="col-md-12">
<p>How Propelyze Supports Your Workflow</p>
<h4>A Modern Approach to Streamlined Property Data Management</h4>
<p>Propelyze brings property research, pricing, and record management into one workflow. Use the available tools to review locations, compare properties, and prepare your marketing data. Explore the sections below for guidance on search fields and export options.</p>
<h4>Advanced Data Integration</h4>
<p>Propelyze pulls data from many trusted sources, including Zillow, Lands of America, Realtor.com, Redfin, LandFlip, and many other local property databases. We ensure comprehensive market insights and precise property valuations by consolidating information from these diverse platforms. Our integration allows for accurate and immediate search results, helping you make informed decisions quickly.</p>
<h4>Dynamic Pricing Options</h4>
<p>We offer a range of pricing models tailored to your needs. Choose from our regional, municipal, or specialized geo-based pricing plans. Each model starts with calculating your selected area&apos;s average market value per acre and allows for flexible adjustments based on local market conditions. This ensures you receive the most relevant pricing for your property offers.</p>

<p>We account for variations in pricing across different regions and acreage sizes, allowing you to fine-tune the offer price per acre according to your preferences.</p>
<h4>Location Insights and Ranking</h4>
<p>Our advanced tool swiftly pinpoints counties and acreage ranges that perfectly match your search criteria. With seamless DataTree integration, we provide precise parcel counts for each location, giving you a clear understanding of how many parcels are available for download in your selected areas. This helps you focus your efforts on the most relevant locations.</p>
<h4>Seamless Data Extraction</h4>
<p>Propelyze, as a licensed DataTree partner, simplifies property data retrieval by directly handling the extraction process. You receive detailed reports featuring extensive property data, including valuation and geographic information. Our platform delivers all the essential information needed for informed decision-making, covering various land types and property attributes.</p>


<p>Search Criteria</p>
<h4>View Search Options</h4>
<p>To find out more about our search options, review the labels and help text beside the search fields.</p>
<h4>Saved Searches</h4>
<p>This tool lets you save as many different search setups as you need for all your unique strategies.</p>
<h4>Polygon Search</h4>
<p>Activate the lasso/polygon tool by choosing it from the toolbar. This functionality lets you define specific property searches within a designated area. Please note that this feature&apos;s availability may differ based on your subscription tier.</p>
<h4>Get Count&nbsp;</h4>
<p>Instantly check the number of owners that match your search parameters.</p>
<h4>Search Bar</h4>
<p>Start by inputting a state, county, city, or zip code in the search field. With this basic information, you can conduct a general search or fine-tune your results by applying advanced filters for more specificity.</p>
<h4>Multiple Area Search</h4>
<p>This feature allows you to conduct searches in multiple locations simultaneously. Simply enter a location in the search box and utilize this tool to add it to your selected areas.</p>
<h4>Search&nbsp;</h4>
<p>Click the search button to view your results instantly. This allows you to quickly access the data you need.</p>
<h4>Advanced Search</h4>
<p>Expand or collapse advanced search fields by clicking the option. This lets you adjust your search parameters easily.</p>
<h4>Secondary Acreage Increment</h4>
<p>Increase the size of acreage intervals to enhance your search. This allows for a broader selection of results.</p>
<h4>Minimum Acreage</h4>
<p>Please indicate the smallest land size you would like us to consider during your search.&nbsp;</p>
<h4>Maximum Acreage&nbsp;</h4>
<p>Let us know the largest size of land you wish to have included in your search criteria.</p>
<h4>Acreage Increment</h4>
<p>This option enables you to see land categorized by specific size ranges. For example, if you choose a 10-acre increment, the results will be organized into categories like 0 to 10 acres, 10 to 20 acres, etc. Conversely, if you opt for an increment of 3, the results will be displayed in ranges such as 0 to 3 acres and 3 to 6 acres. Additionally, we will include an estimated price or offer for each acre within these size categories.</p>
<h4>Lowest Price per Acre</h4>
<p>Specify the lowest price per acre you expect in the outcomes. This figure is determined by the average prices in the county.</p>
<h4>Highest Price per Acre</h4>
<p>Indicate the highest price per acre you would like to see. This amount represents the standard pricing within the county.</p>
<h4>Discount Percentage</h4>
<p>Determine the percentage discount you wish to apply to the market rate for each acre. This can be modified on the results page and will affect the final purchase price criteria utilized in your search.</p>
<h4>Minimum Budget</h4>
<p>Identify the least amount you are ready to allocate to acquire a property.</p>
<h4>Maximum Budget</h4>
<p>Specify the maximum amount you are willing to invest in buying a property.</p>
<h4>Pricing Options</h4>
<p>Decide on your preferred method for evaluating property values. You can opt for a range of comparisons, focus solely on active listings, or examine sold properties. Additionally, you can tailor the criteria to narrow down the comparisons used in your pricing evaluation.</p>

<h4>View Search Options</h4>
<p>For more information about our search options, place your cursor over any input fields on the left!</p>
<h4>Select Land Uses/Property Types</h4>
<p>Select the categories of land or properties for your search by marking or unmarking the boxes adjacent to each option, making it easy to customize your search criteria.</p>
<h4>Additional Land Uses</h4>
<p>Explore a wider variety of land use possibilities, encompassing different types of residential options, and determine if you want to include all categories of land use in your search.</p>
<h4>In State Owner</h4>
<p>Decide if you want to include property owners whose mailing address is within the same state as the property, useful for targeting local owners.</p>
<h4>In County Owner</h4>
<p>Decide whether to incorporate or omit owners depending on whether their mailing address is in the same county as the property, helpful for more localized searches.</p>
<h4>Owner Occupied</h4>
<p>Sort according to whether the owner&apos;s mailing address aligns with the property&apos;s address, ideal for identifying owner-occupied properties.</p>
<h4>Corporate-Owned Properties</h4>
<p>Incorporate or omit assets that are held by companies.</p>
<h4>Do Not Mail</h4>
<p>Exclude property owners who have opted out of receiving mail, ensuring your marketing efforts respect their preferences.</p>
<h4>Number of Properties Owned</h4>
<p>Look up information according to the number of properties owned by an individual, which can be useful for identifying major property owners.</p>
<h4>Owner Name</h4>
<p>Locate property owners using their individual names, making it easy to find specific owners.</p>
<h4>Mailing State</h4>
<p>Focus your search on property owners within a specific state, allowing you to target particular regions effectively.</p>
<h4>Mailing Zip Code</h4>
<p>Refine your search to include only owners in a specific zip code, ideal for pinpointing precise geographic areas.</p>

<h4>Assessed Improvement Percentage %</h4>
<p>Discover properties by evaluating the percentage of upgrades, including structures or buildings. The county assessor&apos;s office calculates this improvement percentage, allowing you to sort properties according to the enhancements.</p>
<h4>Assessed Value ($)</h4>
<p>Search for properties within a specified range of assessed land value. The county assessor sets this value, which helps you identify properties based on their land worth.</p>
<h4>Assessed Land Value</h4>
<p>Search for properties based on the evaluated worth of enhancements such as buildings, wells, or other improvements. The county assessor determines this valuation, which aids in identifying properties that have undergone substantial upgrades.</p>
<h4>Market Improvement Value</h4>
<p>Sort properties according to the assessed market value of any upgrades. This encompasses improvements like structures or wells, with values determined by the county assessor&apos;s office.</p>
<h4>Market Land Value</h4>
<p>Look for properties that fall within a specific range of land value in the market. The county assessor&apos;s information enables you to identify properties according to their present market value.</p>
<h4>Tax Status</h4>
<p>Locate properties whose owners are either up-to-date or behind on their tax payments. This criterion allows you to focus on properties with particular tax payment conditions.</p>
<h4>Cities</h4>
<p>Search for real estate in a particular city to focus your search on urban locations that interest you.</p>
<h4>Zip Code</h4>
<p>Look for real estate in a designated zip code. This allows you to concentrate on specific areas or postal districts.</p>
<h4>Subdivision</h4>
<p>Find real estate options in a specific neighborhood. This filter lets you focus on some residential regions or planned housing projects.</p>
<h4>Census Tract</h4>
<p>Look for properties located within a specified census tract. It enables you to concentrate on particular demographic or regional zones.</p>
<h4>Zoning</h4>
<p>Search for properties according to their zoning designations, like residential or agricultural categories (for instance, A1 or R1). This ensures that the properties align with your zoning criteria.</p>
<h4>Living Area Size</h4>
<p>Look for properties by their square footage of living space. If you want entirely unoccupied land, adjust both the minimum and maximum values to zero.</p>
<h4>Homeowners Association (HOA)</h4>
<p>Narrow down your property search by their HOA membership status. This allows you to locate homes affiliated with an HOA or those that aren&rsquo;t.</p>
<h4>Unassigned Address</h4>
<p>Look for properties that either possess an assigned address or lack one altogether. This can be helpful in identifying properties with particular addressing concerns.</p>
<h4>APN Range</h4>
<p>Locate properties based on a designated range of Assessor&apos;s Parcel Numbers (APN). This functionality enables searches using specific APN ranges or blocks for accurate targeting.</p>
<h4>Flood Zone Codes</h4>
<p>Filter properties by specific flood zone codes to assess flood risk and zoning requirements.</p>
<h4>Last Sale Date&nbsp;</h4>
<p>Search properties by the most recent sale date, with options to filter by date range or a specific timeframe.</p>
<h4>Last Sale Price</h4>
<p>Find properties by their last sale price to focus on those within your preferred price history.</p>
<h4>Deed Type</h4>
<p>Locate properties by the type of deed, offering insights into ownership and transaction details.</p>
<h4>Listing Status</h4>
<p>Filter by current listing status, like active or pending, to find properties still on the market.</p>
<h4>Clear Search</h4>
<p>Quickly clear all search criteria and return to the default settings for a fresh start.</p>

<h3>Result fields</h3>
<h4>View Search Options
</h4>
<p>Review the result field descriptions below to understand the available data.</p>
<h4>Pricing Scheme Selection</h4>
<p>Pick from our available pricing plans to set the property values based on your needs.</p>
<h4>Total Records and Costs</h4>
<p>See the total number of records you&apos;ve selected and the estimated cost before downloading.</p>
<h4>Finalize and Download</h4>
<p>After selecting your target areas, proceed to download the data. The next step will allow you to choose the fields for data scrubbing.</p>
<h4>Offer Price Change</h4>
<p>Easily update the offer price per acre for any property row. Select a row, input your new price, and save the changes instantly.</p>
<h4>For Sale and Sold Comps</h4>
<p>Review similar properties that have been recently sold or are currently for sale, helping you gauge market conditions.</p>
<h4>City-Specific Pricing</h4>
<p>Dive into detailed pricing for each city within your search area, with the option to fine-tune prices at the city level.</p>
<h4>Sort</h4>
<p>Sort the data by various columns to better analyze the properties that meet your criteria.</p>
<h4>Set Default Sort</h4>
<p>Choose how you want your data to be sorted by default and apply it across your searches.</p>
<h4>Adjust Offer Price Percent</h4>
<p>Quickly modify the market value percentage to refine your offer prices per acre using an easy slider.</p>
<h4>Adjust Selected Row</h4>
<p>Apply changes to the market value percentage for specific rows only, giving you more control over your offer strategy.</p>
<h4>Select All Variant</h4>
<p>Select records from the DataTree, keeping the count within the 10,000 record limit, while trying to maximize the total up to the 25,000 record cap. The process will automatically halt once the limit is hit, ensuring that the download remains within the allowed maximum.</p>
<h4>Rank</h4>
<p>Our system assesses and scores potential locations using diverse statistical criteria, guiding you to the areas with the highest potential. Key metrics include the quality of natural features, economic performance indicators, and shifts in market values.</p>
<h4>DataTree Owner Record Count</h4>
<p>View the total number of owner records ready for download in a specific target area.</p>
<h4>Total Comps</h4>
<p>Check the total number of comparable sales within your selected location and acreage range, offering insights into market trends.</p>
<h4>Parcels on Market Ratio</h4>
<p>This ratio indicates the proportion of parcels currently listed for sale compared to the total parcels available, based on data from various land listing platforms.</p>
<h4>County</h4>
<p>The county where your area of interest is situated.</p>
<h4>State</h4>
<p>The state in which your target location resides.</p>
<h4>Acreage</h4>
<p>The area of land in your target location, including nearby properties for context.</p>
<h4>Offer Price/Acre</h4>
<p>When you choose County Pricing, this rate determines the offer price for your selected area. For City Pricing, this rate does not apply. With Geo Pricing, this value serves as the starting point for adjustments by our Geo Pricing Algorithm. You can modify this amount by adjusting the offer price slider or entering a new price per acre in the designated field.</p>


<h4>Market Price/Acre</h4>
<p>This figure represents the assessed market value per acre for the chosen location.</p>
<h4>Export</h4>
<p>Choose the specific data you wish to download by checking the boxes next to each target area.</p>
<h4>Export Analysis Results</h4>
<p>Transfer the data table&rsquo;s locations and values for additional analysis. This feature is available with certain subscription plans.</p>

<h3>For Sale and Sold Comps</h3>
<h4>View Search Options
</h4>
<p>To discover more about our compensation data, simply place your cursor over any of the highlighted areas on the left!</p>
<h4>Parcel Comp Count</h4>
<p>This shows the total number of comparables for sale and recently sold within a specific county and land size range.</p>
<h4>Comp Chart</h4>
<p>View a scatter chart displaying the spread of comparable prices visually.</p>
<h4>Projected Average Offer Price</h4>
<p>This is the average bid price for properties in a specific county and land size range. For instance, if you&apos;re looking at properties between 25 and 30 acres, the estimated average bid price will reflect the value for a 27.5-acre property.</p>
<h4>Comp Sorting</h4>
<p>Organize comparables by any column you choose.</p>
<h4>Comp Filtering</h4>
<p>Select filters to find specific comparables.</p>
<h4>Comp Price</h4>
<p>How much each comparable property costs.</p>
<h4>Comp Acreage</h4>
<p>The size of each comparable property.</p>
<h4>Comp Price Per Acre</h4>
<p>The cost for each acre of a comparable property.</p>
<h4>Comp City</h4>
<p>The city where the comparable property is located.</p>
<h4>Comp Status</h4>
<p>Shows if the property is for sale or has been sold.</p>
<h4>Comp List Date</h4>
<p>When the property was first listed.</p>
<h4>Comp Sold Date</h4>
<p>When the property was sold, if available.</p>
<h4>Comp Source</h4>
<p>This indicates where each comparable property was listed. You can click the provided link to view the listing, except for sold properties from Realtor.com, which do not have clickable links.</p>
<h4>Comp Export</h4>
<p>Download comparables into an Excel file for detailed analysis and custom pricing. This feature is available with certain subscription plans on Propelyze.</p>

<h3>City Level Pricing</h3>
<h4>View Search Options
</h4>
<p>For more information about our city pricing, simply place your cursor over any of the highlighted areas to the right!</p>
<h4>Save City Pricing</h4>
<p>Keep track of any updates to city prices, including adding new cities.</p>
<h4>Add a City</h4>
<p>Allows you to include a new city that isn&apos;t listed.</p>
<h4>City Pricing Chart</h4>
<p>Shows a visual overview of offer prices for different cities in your area.</p>
<h4>County Level Market Price Per Acre</h4>
<p>Displays the average market price per acre for the county.</p>
<h4>County Level Offer Price Per Acre</h4>
<p>Shows the average offer price per acre for the county.</p>
<h4>Selected City</h4>
<p>Shows the city you have selected.</p>
<h4>Selected City Market Price</h4>
<p>Shows the market rate per acre for the city you&apos;ve chosen. You can also enter your own rate to adjust it.</p>
<h4>Selected City Offer Price</h4>
<p>Displays the offer rate per acre for the selected city. You can modify this rate by entering a new value.</p>
<h4>Update City Pricing</h4>
<p>Click here to save any updates made to city pricing.</p>
<h4>City</h4>
<p>The name of the city.</p>
<h4>City Market Price Per Acre</h4>
<p>The average market rate per acre in a city for a given land size.</p>
<h4>City Offer Price Per Acre</h4>
<p>The offer rate per acre in a city for a specific land size.</p>
<h4>City Z-Score</h4>
<p>This score indicates the difference between the city and county market prices per acre. A positive score means city prices are higher, while a negative score means they are lower.</p>
<h4>City Comp Count</h4>
<p>Shows how many comparable properties are available in our database for the selected city and land size.</p>
<h4>City Export</h4>
<p>Download data on comparables for the chosen city and acreage from our database.</p>

<h3>Scrub Field Names</h3>
<h4>View Search Options
</h4>
<p>Review the filter descriptions and help text to understand each option.</p>
<h4>Saved Configurations</h4>
<p>Save/load your scrub field name setup.</p>
<div>
<ul>
<li>
<h4>Default Fields (Cannot Exclude)</h4>
</li>
</ul>
</div>
<h4>Reference Number</h4>
<p>Unique tracking number for each property, provided by Propelyze.</p>
<h4>Offer Price</h4>
<p>The recommended offer price for the property by Propelyze.</p>
<h4>APN</h4>
<p>The Assessor&apos;s Parcel Number for the property you&apos;re interested in.</p>
<h4>Mailing Address</h4>
<p>The street address where you send correspondence.</p>
<h4>Mailing Zip Code</h4>
<p>The postal code for the recipient&rsquo;s address.</p>
<h4>Mailing City</h4>
<p>The city where the recipient is located.</p>
<h4>Mailing State</h4>
<p>The state where the recipient&rsquo;s address is found.</p>
<div>
<ul>
<li>
<h4>Pricing Fields</h4>
</li>
</ul>
</div>
<h4>Market Price</h4>
<p>The final property value forecasted by Propelyze.</p>
<h4>Offer Percent</h4>
<p>The percentage of the market value used to determine the offer price.</p>
<h4>County Assessed Value</h4>
<p>The property value is assessed by the county or local authority, including both land and improvements.</p>
<h4>County Market Value</h4>
<p>The county or local tax authority provides the market valuation for land and improvements.</p>
<h4>DataTree Estimated Value</h4>
<p>The projected property value is calculated through DataTree&apos;s AVM.</p>
<h4>Pricing Source (Land)</h4>
<p>Indicates whether the property&rsquo;s pricing is based on county, city, or regional data.</p>
<h4>Pricing Source Market Price (Land)</h4>
<p>The price per acre used to value this property is based on the pricing source.</p>
<h4>Pricing Source Offer Price (Land)</h4>
<p>The proposed price per acre for the property as determined by the pricing source.</p>
<div>
<ul>
<li>
<h4>Property Fields</h4>
</li>
</ul>
</div>
<h4>Property Address</h4>
<p>The street address for the property you&rsquo;re interested in buying.</p>
<h4>Property Zip Code</h4>
<p>The zip code associated with the property you&rsquo;re considering.</p>
<h4>Property City</h4>
<p>The city where the property is located.</p>
<h4>Property County</h4>
<p>The county where the property is situated.</p>
<h4>Property State</h4>
<p>The state in which the property resides.</p>
<h4>Property State Short</h4>
<p>The abbreviated form of the state where the property is located.</p>
<h4>Property Address Full</h4>
<p>The complete street address of the property you&rsquo;re looking to purchase.</p>
<h4>Property Zoning</h4>
<p>The zoning designation assigned by the county for the property.</p>
<h4>Property Subdivision</h4>
<p>The name of the subdivision where the property is situated.</p>
<h4>Property Section</h4>
<p>Refers to a 1-square-mile area within a larger range or township, with 36 such sections making up each range or township.</p>
<h4>Property Township</h4>
<p>The township segment of the property&apos;s location, determined through local surveys, usually extends six miles north or south from a fixed meridian.</p>
<h4>Property Range</h4>
<p>Based on local surveys, the range segment of the property&apos;s coordinates typically extends six miles east or west from a fixed meridian.</p>
<h4>Property Land Use</h4>
<p>The land use category assigned by DataTree for the property you&apos;re considering.</p>
<h4>Property Latitude</h4>
<p>The latitude coordinate of the property&rsquo;s location.</p>
<h4>Property Longitude</h4>
<p>The longitude coordinate of the property&apos;s location.</p>
<h4>Property Tax</h4>
<p>The amount of tax assessed on the property by local authorities.</p>
<h4>Property Tax Year</h4>
<p>The year for which the local authorities have issued property tax bills.</p>
<h4>Lot Acreage</h4>
<p>The total land area of the property you&rsquo;re interested in.</p>
<h4>Lot Area</h4>
<p>The portion of the property that is available for practical use or development.</p>
<h4>Building Square Footage</h4>
<p>The total area covered by any buildings on the property.</p>
<h4>Legal Description</h4>
<p>The formal description detailing the legal boundaries and characteristics of the property, including subdivision or survey information.</p>
<h4>Last Sale Date</h4>
<p>The date on which the property was last sold.</p>
<h4>Last Sale Price&nbsp;</h4>
<p>The selling price of the property from its last market transaction.</p>
<div>
<ul>
<li>
<h4>Owner Fields</h4>
</li>
</ul>
</div>
<h4>Owner First Name</h4>
<p>The given name of the property owner you&rsquo;re contacting.</p>
<h4>Owner Last Name</h4>
<p>The surname of the property owner you&rsquo;re reaching out to.</p>
<h4>Owner Full Name</h4>
<p>The complete name of the property owner you&rsquo;re addressing.</p>
<h4>Owner Mailing Name</h4>
<p>The name used for sending correspondence to the property owner, which might be a single name or a combination of names.</p>
<h4>Owner Type</h4>
<p>The category assigned to the owner by the county for mailing purposes.</p>
<div>
<ul>
<li>
<h4>Other Fields</h4>
</li>
</ul>
</div>
<h4>Estimated Closing Date</h4>
<p>The anticipated date when the transaction will be completed, typically set for 90 days from now.</p>
<h4>Offer Expiration Date</h4>
<p>The date when the offer is expected to expire, typically 60 days from now.</p>
<h4>Date</h4>
<p>The date on which the data was retrieved.</p>
<h4>Unformatted APN</h4>
<p>The unformatted Assessor&apos;s Parcel Number for the property.</p>
<h4>Alternate APN</h4>
<p>A secondary Assessor&apos;s Parcel Number for the property, if there is one.</p>
<h4>County Land Use</h4>
<p>The land use code assigned by local authorities for the property.</p>
<h4>Mailing Zip Code 9</h4>
<p>The full nine-digit postal code for the property owner&rsquo;s address.</p>
<h4>Full Mailing Address</h4>
<p>The complete address where you send mail to the property owner.</p>

<h3>Scrub Filters</h3>
<h4>View Search Options
</h4>
<p>Review the filter descriptions and help text to understand each option.</p>
<h4>Blank Owners</h4>
<p>Excludes records where the owner&apos;s first or last name is not provided.</p>
<h4>Church owners</h4>
<p>Excludes properties owned by religious institutions.</p>
<h4>Government Owners</h4>
<p>Excludes properties owned by government entities.</p>
<h4>Trust Owners</h4>
<p>Excludes properties held by trusts.</p>
<h4>Corporate Owners</h4>
<p>Excludes properties owned by businesses or corporations.</p>
<h4>Blank Addresses</h4>
<p>Excludes records where mailing addresses, including ZIP codes, are not available.</p>
<h4>Non-US Addresses</h4>
<p>Excludes records with addresses located outside the United States.</p>
<h4>Same Zip Code As Parcel</h4>
<p>Excludes records where the parcel and owner&apos;s mailing address share the same ZIP code.</p>
<h4>Undivided Interest/Severed Surface Rights</h4>
<p>Excludes records involving undivided interests or severed surface rights.</p>
<h4>Last Sale Price Value</h4>
<p>Excludes records where the offer price is below a specified percentage of the last sale price (input your percentage).</p>
<h4>Purchase Price</h4>
<p>Excludes records where the purchase price falls outside your defined range.</p>
<h4>Saved Configurations</h4>
<p>Save and load your filter configurations.</p>
<h3>Download Options</h3>
<h4>View Search Options
</h4>
<p>Review the download options and their descriptions before exporting.</p>
<h4>Generate Campaign Map</h4>
<p>Create a KML file that maps out all your owner information and nearby geotagged comparisons. This file can be viewed using Google Earth or Maps to get a clear view of your campaign&rsquo;s coverage.</p>
<h4>Remove Duplicate Owner Records</h4>
<p>Automatically removes any repeated owner entries before you download. We&rsquo;ll adjust your account if duplicates are detected, as we only know the exact number post-download.</p>
<h4>Split Pricing</h4>
<p>Divide your cleaned data into two separate files: one with complete pricing ready for mailing and another with data that needs manual pricing adjustments due to incomplete details.</p>
<h4>Revert City Pricing</h4>
<p>The system will default to county-level pricing if the Geo Pricing model is unavailable. This option allows you to switch back to city-based pricing.</p>
<h4>Sort Scrubbed File</h4>
<p>Organize your cleaned data by various fields to make it easier to navigate and manage.</p>
<h4>Preview Records</h4>
<p>You can view a sample of your selected records before downloading them. The preview will be sent to your email address for review.</p>
<h4>Checkout</h4>
<p>Complete your transaction and proceed to checkout.</p>

<h3>What does a download look like?</h3>
<h4>Download Includes 7&ndash;8 Files:
</h4>
<p>*Final List</p>
<h4>Propelyze Final List.csv</h4>
<p>1. Customized data file with selected columns for your mailing campaigns.</p>
<p>2. Contains individual offer prices for each property.</p>
<p>3. Prepared and organized for marketing use.</p>
<h4>DataTree Export - Raw.csv</h4>
<p>1. Export of unprocessed data from DataTree.&nbsp;</p>
<p>2. A comprehensive file containing all property records has been downloaded.&nbsp;</p>
<p>3. Each property record features detailed information with 232 data points.&nbsp;</p>
<p>4. Field definitions are provided for your convenience.</p>

<p>Additional Charge&nbsp;</p>
<h4>Propelyze Campaign Map.kml</h4>
<p>1. An extensive map that displays all ownership records along with similar properties in the vicinity.&nbsp;</p>
<p>2. It is compatible with Google Earth and Google Maps for straightforward visualization.</p>
<h4>Export Parameters.csv</h4>
<p>1. Overview of the criteria applied for your data export.&nbsp;</p>
<p>2. This includes information like reference ID, geographical area, range of acreage, and price per acre.</p>
<h4>Export Options.csv</h4>
<p>1. A summary of the decisions taken during your export process.&nbsp;</p>
<p>2. Insights on eliminating duplicates, creating maps, and available pricing alternatives.</p>
<h4>Search Parameters.csv</h4>
<p>1. Overview of the parameters utilized to locate records.&nbsp;</p>
<p>2. Contains information about the search area and any specialized search parameters employed.</p>
<h4>Scrub Filters.csv</h4>
<p>1. Overview of the filters implemented throughout the data cleansing procedure.&nbsp;</p>
<p>2. This includes a comprehensive list of all the scrub filters utilized along with their current application status.</p>
<h4>Scrubbed Out Property Data.csv</h4>
<p>1. Detailed list of properties removed during the scrubbing phase.</p>
<p>2. Can be reintegrated into the main file if necessary.</p>


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