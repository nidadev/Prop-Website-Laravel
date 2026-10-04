@extends('layouts.app2')

@section('content')
<section id="center" class="center_reg">
    <div class="center_om bg_backo">
        <div class="container-xl">
            <div class="row center_o1 m-auto text-center">
                <div class="col-md-12">
                    <h4 class="text-white">How Propelyze Works for Houses</h4>
                        <h6 class="text-white mb-0 mt-3"><a class="text-white" href="{{ url('/home') }}">Home</a> <span class="mx-2 text-warning">/</span> Houses </h6>
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
<p>Propelyze leverages data from top-tier sources like Redfin and DataTree to deliver accurate and up-to-date property insights. We ensure comprehensive market insights and precise property valuations by consolidating information from these diverse platforms. Our integration allows for accurate and immediate search results, helping you make informed decisions quickly.</p>
<h4>Dynamic Pricing Options</h4>
<p>At Propelyze, we use data from trusted sources like DataTree and Redfin to estimate each property&apos;s market value. We then tailor offer prices to reflect each property&apos;s unique characteristics. You can adjust your offers based on these estimates, ensuring your pricing strategy aligns with your goals.</p>
<h4>Location Insights and Ranking</h4>
<p>Our advanced tool swiftly pinpoints zip codes that perfectly match your search criteria. By integrating DataTree, we provide detailed counts of available properties in each area. This ensures you have a comprehensive overview, allowing you to make informed decisions and target the most promising locations easily.</p>
<h4>Seamless Data Extraction</h4>
<p>Propelyze, as a licensed DataTree partner, simplifies property data retrieval by directly handling the extraction process. We provide detailed reports that encompass over 200 data points per property, including key metrics like days on market and median sales price. Our comprehensive exports offer valuable insights into valuation and geographic details, ensuring you have all the critical information needed for strategic decision-making.</p>
<h3 >Search Criteria</h3>
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
<h4>Radius Around City</h4>
<p>When searching by city, you can specify a radius to find all relevant locations, such as counties or zip codes, within that distance. This helps in targeting a broader area around your selected city.</p>
<h4>Land Use/Property Type</h4>
<p>Choose the land uses or property types that you want to include in your search. You can easily select or deselect each type by checking the appropriate box.</p>
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
<h4>Mailing Zip Code</h4>
<p>Refine your search to include only owners in a specific zip code, ideal for pinpointing precise geographic areas.</p>
<h4>Assessed Improvement %</h4>
<p>Discover properties by evaluating the percentage of upgrades, including structures or buildings. The county assessor&apos;s office calculates this improvement percentage, allowing you to sort properties according to the enhancements.</p>
<h4>Assessed Value ($)</h4>
<p>Search for properties within a specified range of assessed land value. The county assessor sets this value, which helps you identify properties based on their land worth.</p>
<h4>DataTree Estimated Value</h4>
<p>Utilize DataTree&apos;s automated valuation model (AVM) to identify properties that fall below, exceed, or lie within a specified value range.</p>
<h4>Home Equity Percent</h4>
<p>Find properties by applying filters to identify those with an owner&apos;s equity percentage that is higher, lower, or falls within a designated range.</p>

<h4>Living Area (Sq Ft)</h4>
<p>Look for properties by their square footage of living space. If you want entirely unoccupied land, adjust both the minimum and maximum values to zero.</p>
<h4>Lot Area</h4>
<p>Identify properties that meet your required acreage by establishing precise lot size criteria.</p>
<h4>Year Built</h4>
<p>Filter properties based on the year they were constructed.</p>
<h4>Bedrooms</h4>
<p>Search for homes that have the exact number of bedrooms you prefer.</p>
<h4>Bathrooms</h4>
<p>Locate properties with the number of bathrooms that suit your requirements.</p>
<h4>Garage Spaces</h4>
<p>Identify homes with the garage space you need.</p>
<h4>Pool Option</h4>
<p>Narrow down your search to properties that either include or exclude a swimming pool.</p>
<h4>HOA</h4>
<p>Narrow down your property search by their HOA membership status. This allows you to locate homes affiliated with an HOA or those that aren&rsquo;t.</p>
<h4>Subdivision</h4>
<p>Find real estate options in a specific neighborhood. This filter lets you focus on some residential regions or planned housing projects.</p>
<h4>Census Tract</h4>
<p>Look for properties located within a specified census tract. It enables you to concentrate on particular demographic or regional zones.</p>
<h4>Zoning</h4>
<p>Search for properties according to their zoning designations, like residential or agricultural categories (for instance, A1 or R1). This ensures that the properties align with your zoning criteria.</p>
<h4>APN Range</h4>
<p>Locate properties based on a designated range of Assessor&apos;s Parcel Numbers (APN). This functionality enables searches using specific APN ranges or blocks for accurate targeting.</p>
<h4>Flood Zone Codes</h4>
<p>Filter properties by specific flood zone codes to assess flood risk and zoning requirements.</p>
<h4>Last Sale Date&nbsp;</h4>
<p>Search properties by the most recent sale date, with options to filter by date range or a specific timeframe.</p>
<h4>Last Sale Price</h4>
<p>Find properties by their last sale price to focus on those within your preferred price history.</p>
<h4>Foreclosure Recorded Date</h4>
<p>Locate properties that have had foreclosures documented on a particular date, or establish parameters to look for those that were filed either prior to or after your selected date.</p>
<h4>Deed Type</h4>
<p>Locate properties by the type of deed, offering insights into ownership and transaction details.</p>
<h4>Listing Status</h4>
<p>Filter by current listing status, like active or pending, to find properties still on the market.</p>
<h4>Clear Search</h4>
<p>Quickly clear all search criteria and return to the default settings for a fresh start.</p>
<h3 >Result Fields</h3>
<h4>View Search Options</h4>
<p>Review the result field descriptions below to understand the available data.</p>
<h4>Offer Price Examples</h4>
<p>Explore potential offer prices across different property values based on the market price percentage you&apos;ve chosen.</p>
<h4>Total Records and Costs</h4>
<p>See the total number of records selected and the associated cost for exporting the data.</p>
<h4>Continue with Export</h4>
<p>Click to move forward once you&apos;ve chosen your target locations. You&apos;ll be taken to the next step, where you can choose your desired data fields.</p>
<h4>Redfin Market Data</h4>
<p>Access key housing data for your selected area, sourced from Redfin, a leading national real estate brokerage.</p>
<h4>Show Offer Price All Increments</h4>
<p>Upon download, view a detailed list of offer prices at 5% increments, ranging from 5% to 95% of the property&apos;s market value. For example, if the market value is $100k, you&apos;ll see offer prices from $5k to $95k.</p>
<h4>Sort</h4>
<p>Sort the data by various columns to better analyze the properties that meet your criteria.</p>
<h4>Set Default Sort</h4>
<p>Choose how you want your data to be sorted by default and apply it across your searches.</p>
<h4>Adjust Offer Price Percent</h4>
<p>Quickly modify the market value percentage to refine your offer prices per acre using an easy slider.</p>
<h4>Select All Variant</h4>
<p>Select records from the DataTree, keeping the count within the 10,000 record limit, while trying to maximize the total up to the 25,000 record cap. The process will automatically halt once the limit is hit, ensuring that the download remains within the allowed maximum.</p>
<h4>Rank</h4>
<p>Our system assesses and scores potential locations using diverse statistical criteria, guiding you to the areas with the highest potential. Key metrics include the quality of natural features, economic performance indicators, and shifts in market values.</p>
<h4>DataTree Owner Record Count</h4>
<p>View the total number of owner records ready for download in a specific target area.</p>
<h4>Zip Code</h4>
<p>Focus your search on specific areas by selecting the desired zip code.</p>
<h4>County</h4>
<p>The county where your area of interest is situated.</p>
<h4>State</h4>
<p>The state in which your target location resides.</p>
<h4>Average Market Duration</h4>
<p>Identify areas based on the average number of days properties stay on the market.</p>
<h4>New Listings to Sold Percent</h4>
<p>Compare the ratio of newly listed properties to recently sold ones within a specific area. This metric helps gauge market activity and trends in your chosen location.</p>


<h4>Parcels on Market Ratio</h4>
<p>This ratio indicates the proportion of parcels currently listed for sale compared to the total parcels available, based on data from various land listing platforms.</p>
<h4>Median Sale Price</h4>
<p>Find the median sale price for properties in a specific area, offering insights into market value and pricing trends for the chosen location.</p>
<h4>Export</h4>
<p>Choose the specific data you wish to download by checking the boxes next to each target area.</p>
<h4>Export Analysis Results</h4>
<p>Transfer the data table&rsquo;s locations and values for additional analysis. This feature is available with certain subscription plans.</p>

<h3 >Scrub Field Names</h3>
<h4>View Search Options</h4>
<p>Review the filter descriptions and help text to understand each option.</p>
<h4>Saved Configurations</h4>
<p>Save/load your scrub field name setup.</p>
<div >
    <ul>
        <li >
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
<div >
    <ul style="margin-bottom:0in;list-style-type: undefined;margin-left:0in;">
        <li >
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
<div >
    <ul style="margin-bottom:0in;list-style-type: undefined;margin-left:0in;">
        <li >
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
<div >
    <ul style="margin-bottom:0in;list-style-type: undefined;margin-left:0in;">
        <li >
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
<div >
    <ul style="margin-bottom:0in;list-style-type: undefined;margin-left:0in;">
        <li >
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
<h3 >Scrub Filters</h3>
<h4>View Search Options</h4>
<p>Review the filter descriptions and help text to understand each option.</p>
<h4>Blank Owners</h4>
<p>Excludes records where the owner&apos;s first or last name is not provided.</p>
<h4>Blank Addresses</h4>
<p>Excludes records where mailing addresses, including ZIP codes, are not available.</p>
<h4>Non-US Addresses</h4>
<p>Excludes records with addresses located outside the United States.</p>
<h4>Purchase Price</h4>
<p>Excludes records where the purchase price falls outside your defined range.</p>
<h4>Saved Configurations</h4>
<p>Save and load your filter configurations.</p>
<h3 style='margin-top:11.0pt;margin-right:0in;margin-bottom:2.0pt;margin-left:0in;'>Download Options</h3>
<h4>View Search Options</h4>
<p>Review the download options and their descriptions before exporting.</p>
<h4>Remove Duplicate Owner Records</h4>
<p>Automatically removes any repeated owner entries before you download. We&rsquo;ll adjust your account if duplicates are detected, as we only know the exact number post-download.</p>
<h4>Split Pricing</h4>
<p>Divide your cleaned data into two separate files: one with complete pricing ready for mailing and another with data that needs manual pricing adjustments due to incomplete details.</p>
<h4>Sort Scrubbed File</h4>
<p>Organize your cleaned data by various fields to make it easier to navigate and manage.</p>
<h4>Preview Records</h4>
<p>You can view a sample of your selected records before downloading them. The preview will be sent to your email address for review.</p>
<h4>Checkout</h4>
<p>Complete your transaction and proceed to checkout.</p>
<h3 style='margin-top:11.0pt;margin-right:0in;margin-bottom:2.0pt;margin-left:0in;'>What does a download look like?</h3>
<h4>Download Includes 7&ndash;8 Files:</h4>
<p>*Final List</p>
<h4>Propelyze Final List.csv</h4>
<p>1. Customized data file with selected columns for your mailing campaigns.</p>
<p>2. Contains individual offer prices for each property.</p>
<p>3. Prepared and organized for marketing use.</p>
<h4>DataTree Export - Raw.csv</h4>
<p>1. Export of unprocessed data from DataTree.&nbsp;</p>
<p>2. A comprehensive file containing all property records has been downloaded.&nbsp;</p>
<p>3. Each property record features detailed information with 232 data points.&nbsp;</p>
<h4>Export Parameters.csv</h4>
<p>1. Overview of the criteria applied for your data export.&nbsp;</p>
<p>2. Contains details like reference numbers, locations, downloaded owner records, and remaining records post-scrubbing.</p>
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