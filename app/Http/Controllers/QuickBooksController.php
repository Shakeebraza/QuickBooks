<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\DataService\DataService;

class QuickBooksController extends Controller
{
    public function connect()
    {
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret' => env('QUICKBOOKS_CLIENT_SECRET'),
            'RedirectURI' => env('QUICKBOOKS_REDIRECT_URI'),
            'scope' => 'com.intuit.quickbooks.accounting',
            'baseUrl' => env('QUICKBOOKS_ENVIRONMENT') === 'sandbox' ? "https://sandbox-quickbooks.api.intuit.com" : "https://quickbooks.api.intuit.com",
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authorizationUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

        return redirect($authorizationUrl);
    }

    public function callback(Request $request)
    {
        $clientID = env('QUICKBOOKS_CLIENT_ID');
        $clientSecret = env('QUICKBOOKS_CLIENT_SECRET');
        $redirectUri = env('QUICKBOOKS_REDIRECT_URI');
        $environment = env('QUICKBOOKS_ENVIRONMENT');

        $code = $request->get('code');
        $realmId = $request->get('realmId');

        if (!$code) {
            return redirect()->route('home')->with('error', 'Authorization code is missing.');
        }

        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => $clientID,
            'ClientSecret' => $clientSecret,
            'RedirectURI' => $redirectUri,
            'baseUrl' => $environment === 'sandbox' ? "https://sandbox-quickbooks.api.intuit.com" : "https://quickbooks.api.intuit.com",
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

        try {
            $accessTokenObj = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Failed to exchange authorization code for access token: ' . $e->getMessage());
        }

        if (!$accessTokenObj) {
            return redirect()->route('home')->with('error', 'Failed to exchange authorization code for access token.');
        }

        // Store tokens and realmId in session or database
        session([
            'accessToken' => $accessTokenObj->getAccessToken(),
            'refreshToken' => $accessTokenObj->getRefreshToken(),
            'realmId' => $realmId
        ]);

        return redirect('/')->with('success', 'Successfully connected to QuickBooks.');
    }

    public function getCompanyInfo()
    {
        $accessToken = session('accessToken');
        $realmId = session('realmId');
        $environment = env('QUICKBOOKS_ENVIRONMENT');

        if (!$accessToken || !$realmId) {
            return redirect()->route('home')->with('error', 'Access token or realm ID is missing.');
        }

        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => env('QUICKBOOKS_CLIENT_ID'),
            'ClientSecret' => env('QUICKBOOKS_CLIENT_SECRET'),
            'RedirectURI' => env('QUICKBOOKS_REDIRECT_URI'),
            'scope' => 'com.intuit.quickbooks.accounting',
            'baseUrl' => $environment === 'sandbox' ? "https://sandbox-quickbooks.api.intuit.com" : "https://quickbooks.api.intuit.com",
            'refreshTokenKey' => session('refreshToken'),
            'QBORealmID' => $realmId,
            'accessTokenKey' => $accessToken,
        ));

        $companyInfo = $dataService->getCompanyInfo();
        return response()->json($companyInfo);
    }
}


