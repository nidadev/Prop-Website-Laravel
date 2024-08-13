@extends('layouts.app')

@section('main')
<section id="center" class="center_reg">
  <div class="center_om bg_backo">
    <div class="container-xl">
      <div class="row center_o1 m-auto text-center">
        <div class="col-md-12">
          <h2 class="text-white">Faq</h2>
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
      <section id="faq" class="p_3 bg-light">
		<div class="container-xl">
			<div class="faq_1 row">
				<div class="col-md-10">
					<div class="faq_1r">
						<h2>Frequently Asked Questions</h2>
						<hr class="line">
						<p></p>
						<div class="accordion" id="accordionExample">
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingOne">
									<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<i class="fa fa-check-circle me-2"></i> ➔	General
									</button>
								</h2>
								<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
									<div class="accordion-body">
										<p class="mb-0"><h5>What Is Propelyze?</h5>
Propelyze is a robust real estate marketing platform designed to streamline your direct mail and digital marketing campaigns. It offers tools for targeting specific areas, pricing mailers, accessing property records, and cleaning your lists for efficient use with your marketing or mailing services.<br>
<h5>What Benefits Does Propelyze Offer?</h5>
Propelyze enhances your marketing efforts by providing in-depth research, competitive pricing models, and advanced location analysis. Our platform simplifies the process of targeting and pricing, ultimately boosting the efficiency of your marketing campaigns.<br>
<h5>Can Propelyze Handle More Than Just Pricing?</h5>
Yes, Propelyze is a comprehensive tool that includes features for research, rapid location searches, property analysis, record access, and list management. This all-in-one approach ensures that your marketing campaigns are well-supported from start to finish.<br>
<h5>Does Propelyze Require Me to Learn a New Pricing Method?</h5>
Not at all. Propelyze is designed to integrate with and enhance your existing pricing methods, automating the processes you are already familiar with for greater efficiency.<br>
<h5>Is Propelyze a Fully Automated System?</h5>
While Propelyze offers significant automation, it cannot replace your decision-making. You will still need to make strategic choices regarding your mailing targets and the content of your offers.<br>
<h5>What Types of Data Are Included in Propelyze?</h5>
Propelyze provides access to extensive property and owner records, with data sourced from multiple reliable platforms to ensure accuracy and relevance for your marketing needs.<br>
<h5>Do I Need an Additional Data Subscription to Use Propelyze?</h5>
No, Propelyze includes all necessary data access within its platform. There’s no need for separate subscriptions or additional contracts.<br>
<h5>How Is the Data in Propelyze Sourced?</h5>
We aggregate data from leading real estate databases and platforms to ensure you have accurate and up-to-date information. This includes property details, ownership records, and market trends that are essential for your marketing efforts.<br>
<h5>Are There Hidden Easter Eggs in Propelyze?</h5>
Yes, Propelyze has hidden Easter eggs throughout the platform for you to discover. These fun surprises can unlock additional features or rewards. Keep exploring and interacting with different parts of the platform to find them. Enjoy the hunt!<br>
<h5>What Should I Do if I Encounter Issues While Using Propelyze?</h5>
If you experience problems, start by refreshing the page to see if the issue resolves. If the problem persists, try clearing your browser’s cache. For continued issues, contact our support team for detailed assistance.<br>
<h5>How Frequently Is the Data Updated?</h5>
We update our data regularly to ensure it remains accurate and relevant. The frequency of updates can vary depending on the data source and type. Rest assured, we strive to provide the most current information available.<br>
<h5>How Can I Contact Propelyze Support via Email?</h5>
To contact Propelyze support via email, simply send your inquiry to support@propelyze.com. Our team aims to respond to all email queries within 24 hours. For faster assistance, please include detailed information about your issue or question in your email.<br>
</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingTwo">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										<i class="fa fa-check-circle me-2"></i> ➔	Search
									</button>
								</h2>
								<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0"><h5>Can I Perform Searches Based on Property Types or Specific Features?</h5>
Yes, Propelyze allows you to search based on property types, features, and other criteria. Use our advanced filters to narrow your search according to specific property characteristics.<br>
<h5>How Does Propelyze Handle Large-Scale Searches?</h5>
Propelyze efficiently manages data processing and displays results in batches for large-scale searches. This ensures that even extensive searches are handled smoothly and without performance issues.<br>
<h5>Is It Possible to Save and Reuse Search Criteria?</h5>
Yes, you can save and reuse your search criteria for future searches. This feature helps streamline your workflow and ensures consistency in your marketing efforts.<br>
<h5>Can I Apply Filters to My Search Results?</h5>
Absolutely. Use the Advanced Search dropdown to access various filters that help you narrow your search results based on your criteria.<br>
<h5>Can New Search Filters Be Added?</h5>
We continuously improve our platform and can integrate new filters based on user feedback. We focus on adding features that offer real value to our users.
</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingThree">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										<i class="fa fa-check-circle me-2"></i> Analysis
									</button>
								</h2>
								<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0"><h5>What Is the Maximum Number of Results I Can View at Once?</h5>
The maximum number of results displayed at one time is 200. Adjust your search criteria to fit within this limit if there are more results.<br>
<h5>Can Propelyze Generate Custom Reports?</h5>
Yes, Propelyze offers customizable reporting features. You can generate reports based on various metrics and criteria, providing valuable insights into your marketing campaigns and property data.<br>
<h5>How Many Property Records Can I Access with Propelyze?</h5>
Propelyze provides access to a vast database of property records. You can download up to 25,000 records per export, allowing for comprehensive analysis and targeted marketing. The exact number of records available depends on your search criteria and data sources.<br>
<h5>How Do I Interpret the Data Analysis Results from Propelyze?</h5>
Our platform includes built-in guidance and tips for interpreting data analysis results. Additionally, our support team is available to assist you in understanding and utilizing the insights provided by the platform.<br>
<h5>How Can I Adjust Pricing for Different Locations?</h5>
Pricing adjustments can be made using tools like the % of the Market slider, or by entering specific offer prices at the county or city level.<br>
<h5>How Frequently Is Property Record Data Updated in Propelyze?</h5>
Property record data in Propelyze is updated regularly to ensure accuracy and relevance. The update frequency may vary based on the data source and the type of information. We work to provide the most current and reliable data for your marketing needs.
</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingFour">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
										<i class="fa fa-check-circle me-2"></i>Scrubbing
									</button>
								</h2>
								<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0"><h5>When Are Scrubbing Features Applied to Data?</h5>
Scrubbing is applied after the data is downloaded. You will be billed for the total number of records you download. Use the advanced search criteria for pre-download filtering.<br>
<h5>Can Custom Scrubbing Filters Be Added?</h5>
Yes, we are open to incorporating new scrubbing filters based on user needs and feedback, provided they offer value to our customer base.<br>
</p>
									</div>
								</div>
							</div>							

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingFive">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
										<i class="fa fa-check-circle me-2"></i>Propelyze Final List File
									</button>
								</h2>
								<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0"><h5>Are the Files I Download from Propelyze Identical to Those from Other Data Sources?</h5>
Yes, the files are the same as those obtained directly from our data sources, ensuring consistency and reliability.<br>
<h5>How Are Data Accuracy and Consistency Ensured in Propelyze Files?</h5>
We ensure data accuracy and consistency by sourcing information from reputable databases and regularly updating our records. Each file you download undergoes rigorous checks to maintain the highest quality and reliability.<br>
<h5>How Are Duplicate Records Managed?</h5>
Duplicates are identified based on mailing addresses and owner names. Records with identical names, but different addresses, will be included separately.<br>
<h5>How Do I Handle KML Files with Propelyze?</h5>
KML files can be viewed using Google Earth or Google Maps. Download Google Earth or use the web-based Google Maps to open and explore these files.<br>
<h5>Why Are My Property APNs Showing Incorrectly in Excel?</h5>
If your APNs appear truncated or displayed as scientific notation in Excel, it's due to Excel's automatic number formatting. This formatting can alter the appearance of large numbers. To fix this, you can either adjust the format settings in Excel or use Google Sheets to correctly view and manage the data.<br>
<h5>How Can I Ensure My Zip Codes Display Correctly in Excel?</h5>
If your zip codes are showing as only 4 digits, this is a formatting issue in Excel. To resolve it, select the column containing zip codes, then adjust the format to "Zip Code" under the Special category. This ensures that all zip codes, including leading zeros, are displayed correctly.<br>

</p>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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