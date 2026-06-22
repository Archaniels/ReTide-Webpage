import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import static com.kms.katalon.core.testobject.ObjectRepository.findWindowsObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testng.keyword.TestNGBuiltinKeywords as TestNGKW
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.windows.keyword.WindowsBuiltinKeywords as Windows
import internal.GlobalVariable as GlobalVariable
import org.openqa.selenium.Keys as Keys

WebUI.openBrowser('')

WebUI.navigateToUrl('https://www.retide.site/')

WebUI.click(findTestObject('Page_ReTide/a_Account'))

WebUI.setText(findTestObject('Page_Login  ReTide/input_nameexample.com'), 'admin123@gmail.com')

WebUI.click(findTestObject('Page_Login  ReTide/input_'))

WebUI.setEncryptedText(findTestObject('Page_Login  ReTide/input_'), 'hUKwJTbofgPU9eVlw/CnDQ==')

WebUI.click(findTestObject('Page_Login  ReTide/button_Sign In'))

WebUI.click(findTestObject('Page_Admin Dashboard - Laravel/a_Marketplace'))

WebUI.click(findTestObject('Page_Admin Dashboard - Laravel/a_Add New Product'))

WebUI.setText(findTestObject('Page_Add Product  ReTide/input_Name'), 'wlomgstffwpubmfpvilsdmgpeapjwwdwqjnzjtcjsxaakivzqghsplvibpoapvkjiahwuhnxsjonirduipwloljvgeolrqbrhcfuqkjecwtutcfveujvoyxoyhzfmsfnmszbhdowupjvfwqunosjwowmczekkshysbpooopqfpvneeegmrvcugpnysxzipidwxuuoejxowmpuhsupuwwywrktdzgeeayclumanbkykrpxgggmjnnndczcezuyglf')

WebUI.setText(findTestObject('Page_Add Product  ReTide/textarea_Description'), 'Test Item')

WebUI.setText(findTestObject('Page_Add Product  ReTide/input_Price'), '10.00')

WebUI.click(findTestObject('Page_Add Product  ReTide/button_Create'))

WebUI.rightClick(findTestObject('Page_Add Product  ReTide/p_The name field must not be greater than 100 ch'))

WebUI.verifyElementPresent(findTestObject('Page_Add Product  ReTide/p_The name field must not be greater than 100 ch'), 
    0)

