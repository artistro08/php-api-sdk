<?php

namespace Printful\Tests\ProductsApi;

use Printful\Structures\Sync\Requests\SyncProductRequest;
use Printful\Structures\Sync\Requests\SyncVariantRequest;
use Printful\Structures\Sync\Responses\SyncProductResponse;
use Printful\Structures\Sync\Responses\SyncVariantResponse;
use Printful\Structures\Sync\SyncProductUpdateParameters;

class UpdateTest extends ProductsApiTestBase
{
    /**
     * Tests SyncProduct update
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulSdkException
     */
    public function testUpdateProduct()
    {
        $syncProduct = $this->createProduct();

        $productRequest = new SyncProductRequest;
        $productRequest->name = 'My new SDK random name ' . rand(1, 10);

        $updateParams = new SyncProductUpdateParameters;
        $updateParams->syncProduct = $productRequest;

        $updatedSyncProduct = $this->apiEndpoint->updateProduct($syncProduct->id, $updateParams);
        $this->assertInstanceOf(SyncProductResponse::class, $updatedSyncProduct);

        $this->assertEquals($productRequest->name, $updatedSyncProduct->name);
    }

    /**
     * Tests SyncVariant update
     *
     * @throws \Printful\Exceptions\PrintfulApiException
     * @throws \Printful\Exceptions\PrintfulException
     * @throws \Printful\Exceptions\PrintfulSdkException
     */
    public function testUpdateVariant()
    {
        $syncProduct = $this->createProduct();
        $syncProduct = $this->apiEndpoint->getProduct($syncProduct->id);

        $variant = $syncProduct->syncVariants[0];

        $request = new SyncVariantRequest;
        $request->externalId = 'my-sdk-updated-external-id-' . rand(1, 10);

        $updatedSyncVariant = $this->apiEndpoint->updateVariant($variant->id, $request);
        $this->assertInstanceOf(SyncVariantResponse::class, $updatedSyncVariant);

        $this->assertEquals($request->externalId, $updatedSyncVariant->externalId);
    }
}